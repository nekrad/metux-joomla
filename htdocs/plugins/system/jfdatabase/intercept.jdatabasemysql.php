<?php
// Don't allow direct linking
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class interceptDB extends JDatabaseMySQL {

	/**
	 * This special constructor reuses the existing resource from the existing db connecton
	 *
	 * @param unknown_type $options
	 */
	function __construct($options){
		$db = & JFactory::getDBO();

		$select		= array_key_exists('select', $options)	? $options['select']	: true;
		$database	= array_key_exists('database',$options)	? $options['database']	: '';

		// perform a number of fatality checks, then return gracefully
		if (!function_exists( 'mysql_connect' )) {
			$this->_errorNum = 1;
			$this->_errorMsg = 'The MySQL adapter "mysql" is not available.';
			return;
		}

		// connect to the server
		$this->_resource = & $db->_resource;

		// finalize initialization
		JDatabase::__construct($options);

		// select the database
		if ( $select ) {
			$this->select($database);
		}

	}

	function _getFieldCount(){
		if (!is_resource($this->_cursor)){
			// This is a serious problem since we do not have a valid db connection
			// or there is an error in the query
			if ($this->getErrorMsg()===""){
				echo JText::_("No valid database connection")."<br/>";
			}
			return 0;
		}

		$fields = mysql_num_fields($this->_cursor);
		return $fields;
	}

	function _getFieldMetaData($i){
		$meta = mysql_fetch_field($this->_cursor, $i);
		return $meta;
	}
	

	function fillRefTableCache($cacheDir,$cacheFile){

		$pfunc = $this->_profile();

		$cacheFileContent = serialize($this->_refTables);
		$handle = @fopen($cacheFile,"wb");
		if ($handle){
			fwrite($handle,$cacheFileContent);
			fclose($handle);
		}
		// clean out old cache files
		// This could be very slow for long list of old files -
		// TODO store in database instead
		$this->cleanRefTableCache($cacheDir);
		
		$pfunc = $this->_profile($pfunc);

	}

	function cleanRefTableCache($cacheDir){

		$pfunc = $this->_profile();

		if (!($dh = opendir($cacheDir))) {
			return false;
		}
		while ($file = readdir($dh)) {
			if (($file != '.') && ($file != '..')) {
				$file = "$cacheDir/$file";
				if (is_file($file) && @filemtime($file) < $this->cacheExpiry) {
					if (!@unlink($file)) {
						echo "problems clearing cache file $file";
					}
				}
			}
		}
		
		$pfunc = $this->_profile($pfunc);

		return true;
	}

	function _logSetRefTablecache($action,$tempsql,$sql_exNos,$sqlHash){

		$pfunc = $this->_profile();

		$logfile = dirname(__FILE__)."/qalog.txt";
		$handle = fopen($logfile,"ab");
		// replace tabs and carriage returns with spaces
		fwrite($handle,"$action ");
		fwrite($handle,preg_replace("/([\t\n\r\f])/"," ",$tempsql));
		fwrite($handle," #@£^£@# ");
		fwrite($handle,preg_replace("/([\t\n\r\f])/"," ",$sql_exNos));
		fwrite($handle," #@£^£@# ");
		fwrite($handle,preg_replace("/([\t\n\r\f])/"," ",$sqlHash));
		fwrite($handle," # JF LINE END# \n");

		fclose($handle);
		
		$pfunc = $this->_profile($pfunc);

	}
	
	function setRefTables(){

		$pfunc = $this->_profile();

		// Before joomfish manager is created since we can't translate so skip this anaylsis
		global $_JOOMFISH_MANAGER;
		if (!$_JOOMFISH_MANAGER) return;

		// This could be speeded up by the use of a cache - but only of benefit is global caching is off
		$tempsql = $this->_sql;
		// only needed for selects at present - possibly add for inserts/updates later
		if (strpos(strtoupper($tempsql),"SELECT")===false) {
		
			$pfunc = $this->_profile($pfunc);

			return;
		}
	
		$config =& JFactory::getConfig();
	
		if ($_JOOMFISH_MANAGER->getCfg("qacaching",1)){
			$cachepath = JPATH_CACHE;
			$cachetime = $config->getValue('config.cachetime',0);
			// remove time formats (assume all numbers are not necessay - this is experimental
			// for example table names or column names could contain numbers
			// so this version only replaces numbers not adjacent to alpha characters i.e.field2 doesn't become field
			$sql_exNos = preg_replace("/(?![a-z])(.)([0-9]+)(?![a-z]+)/i",'${1}',$tempsql);
			$sql_exNos = preg_replace("/(?![a-z]).([0-9]+)$/i",'${1}',$sql_exNos);

			if ( $config->getValue('config.debug',0)) {
				echo "<p style='background-color:bisque;border:solid 1px black'><strong>setRefTables debug:</strong><br / >"
				. "tempsql   = $tempsql<br />"
				. "sql_exNos = $sql_exNos"
				. "</p>";
			}

			$sqlHash = md5($sql_exNos );

			$this->cacheExpiry = time() - $cachetime;
			$cacheDir = "$cachepath/refTableSQL";
			if (!file_exists($cacheDir)) mkdir($cacheDir);
			$cacheFile = "$cacheDir/$sqlHash";
			if (file_exists($cacheFile) &&	@filemtime($cacheFile) > $this->cacheExpiry) {
				$cacheFileContent = file_get_contents($cacheFile);
				$this->_refTables = unserialize($cacheFileContent);

				if ($_JOOMFISH_MANAGER->getCfg("qalogging",0)){
					$this->_logSetRefTablecache("r",$tempsql,$sql_exNos,$sqlHash);
				}
		
				$pfunc = $this->_profile($pfunc);
	
				return;
			}

			if($this->_cursor===true || $this->_cursor===false) {
				if ($_JOOMFISH_MANAGER->getCfg("qalogging",0)){
					$this->_logSetRefTablecache("wtf",$tempsql,$sql_exNos,$sqlHash);
				}
				$this->fillRefTableCache($cacheDir,$cacheFile);
		
				$pfunc = $this->_profile($pfunc);

				return;
			}
		}

		// get column metadata
		$fields = $this->_getFieldCount();

		//print "<br> $tempsql $this->_cursor $fields";

		if ($_JOOMFISH_MANAGER->getCfg("qacaching",1)){
			if ($fields<=0) {
				if ($_JOOMFISH_MANAGER->getCfg("qalogging",0)){
					$this->_logSetRefTablecache("w0f",$tempsql,$sql_exNos,$sqlHash);
				}
				$this->fillRefTableCache($cacheDir,$cacheFile);
		
				$pfunc = $this->_profile($pfunc);

				return;
			}
		}
		if ($fields<=0) {
		
			$pfunc = $this->_profile($pfunc);

			return;
		}
		
		$this->_refTables=array();
		$this->_refTables["fieldTablePairs"]=array();
		$this->_refTables["tableAliases"]=array();
		$this->_refTables["reverseTableAliases"]=array();
		$this->_refTables["fieldAliases"]=array();
		$this->_refTables["fieldTableAliasData"]=array();
		$this->_refTables["fieldCount"]=$fields;
		$this->_refTables["sql"]=$tempsql;
		// local variable to keep track of aliases that have already been analysed
		$tableAliases = array();

		for ($i = 0; $i < $fields; ++$i) {
			$meta = $this->_getFieldMetaData($i);
			if (!$meta) {
				echo "No information available<br />\n";
			}
			else {
				$tempTable =  $meta->table;
				// if I have already found the table alias no need to do it again!
				if (array_key_exists($tempTable,$tableAliases)){
					$value = $tableAliases[$tempTable];
				}
				// mysli only
				else if (isset($meta->orgtable)){
					$value = $meta->orgtable;
					if (isset($this->_table_prefix) && strlen($this->_table_prefix)>0 && strpos($meta->orgtable,$this->_table_prefix)===0) $value = substr($meta->orgtable, strlen( $this->_table_prefix));
					$tableAliases[$tempTable] = $value;
				}
				else {
					if (!isset($tempTable) || strlen($tempTable)==0) {
						continue;
					}
					//echo "<br>Information for column $i of ".($fields-1)." ".$meta->name." : $tempTable=";
					$tempArray=array();
					$prefix = $this->_table_prefix;
					preg_match_all("/$prefix(\w*)\s+AS\s+".$tempTable."[,\s]/i",$this->_sql, $tempArray, PREG_PATTERN_ORDER);
					if (count($tempArray)>1 && count($tempArray[1])>0) $value = $tempArray[1][0];
					else $value = null;
					if (isset($this->_table_prefix) && strlen($this->_table_prefix)>0 && strpos($tempTable,$this->_table_prefix)===0) $tempTable = substr($tempTable, strlen( $this->_table_prefix));
					$value = $value?$value:$tempTable;
					$tableAliases[$tempTable]=$value;
				}

				if ((!($value=="session" || strpos($value,"jf_")===0)) && $this->translatedContentAvailable($value)){
					/// ARGH !!! I must also look for aliases for fieldname !!
					if (isset($meta->orgname)){
						$nameValue = $meta->orgname;
					}
					else {
						$tempName = $meta->name;
						$tempArray=array();
						preg_match_all("/(\w*)\s+AS\s+".$tempName."[,\s]/i",$this->_sql, $tempArray, PREG_PATTERN_ORDER);
						if (count($tempArray)>1 && count($tempArray[1])>0) {
							//echo "$meta->name is an alias for ".$tempArray[1][0]."<br>";
							$nameValue = $tempArray[1][0];
						}
						else $nameValue = $meta->name;
					}
					
					if (!array_key_exists($value,$this->_refTables["tableAliases"])) $this->_refTables["tableAliases"][$value]=$meta->table;
					if (!array_key_exists($meta->table,$this->_refTables["reverseTableAliases"])) $this->_refTables["reverseTableAliases"][$meta->table]=$value;
					
					// I can't use the field name as the key since it may not be unique!
					if (!in_array($value,$this->_refTables["fieldTablePairs"])) $this->_refTables["fieldTablePairs"][]=$value;
					if (!array_key_exists($nameValue,$this->_refTables["fieldAliases"])) $this->_refTables["fieldAliases"][$meta->name]=$nameValue;

					// Put all the mapping data together so that everything is in sync and I can check fields vs aliases vs tables in one place
					$this->_refTables["fieldTableAliasData"][$i]=array("fieldNameAlias"=>$meta->name, "fieldName"=>$nameValue,"tableNameAlias"=>$meta->table,"tableName"=>$value);
					
				}

			}
		}
		if ($_JOOMFISH_MANAGER->getCfg("qacaching",1)){
			if ($_JOOMFISH_MANAGER->getCfg("qalogging",0)){
				$this->_logSetRefTablecache("wn",$tempsql,$sql_exNos,$sqlHash);
			}
			$this->fillRefTableCache($cacheDir,$cacheFile);
		}
		
		$pfunc = $this->_profile($pfunc);


	}
	
}
?>