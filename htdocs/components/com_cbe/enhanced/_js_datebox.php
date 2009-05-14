<?php
/*************************************************************
* Community Builder Enhanced
* Author Phil_K
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$js_cbe_datebox = <<<EOT

<script language="javascript" type="text/javascript">
<!--
// ------------------------------------------------------------------

var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function cbeDateBox_LZ(x) {return(x<0||x>9?"":"0")+x}

// ------------------------------------------------------------------
// isDate ( date_string, format_string )
// Returns true if date string matches format of format string and
// is a valid date. Else returns false.
// It is recommended that you trim whitespace around the value before
// passing it to this function, as whitespace is NOT ignored!
// ------------------------------------------------------------------
function cbeDateBox_isDate(val,format) {
	var date=cbeDateBox_getDateFromFormat(val,format);
	if (date==0) { return false; }
	return true;
	}

// -------------------------------------------------------------------
// compareDates(date1,date1format,date2,date2format)
//   Compare two date strings to see which is greater.
//   Returns:
//   1 if date1 is greater than date2
//   0 if date2 is greater than date1 of if they are the same
//  -1 if either of the dates is in an invalid format
// -------------------------------------------------------------------
function cbeDateBox_compareDates(date1,dateformat1,date2,dateformat2) {
	var d1=cbeDateBox_getDateFromFormat(date1,dateformat1);
	var d2=cbeDateBox_getDateFromFormat(date2,dateformat2);
	if (d1==0 || d2==0) {
		return -1;
		}
	else if (d1 > d2) {
		return 1;
		}
	return 0;
	}

// ------------------------------------------------------------------
// formatDate (date_object, format)
// Returns a date in the output format specified.
// The format string uses the same abbreviations as in getDateFromFormat()
// ------------------------------------------------------------------
function cbeDateBox_formatDate(date,format) {
	format=format+"";
	var result="";
	var i_format=0;
	var c="";
	var token="";
	var y=date.getYear()+"";
	var M=date.getMonth()+1;
	var d=date.getDate();
	var E=date.getDay();
	var H=date.getHours();
	var m=date.getMinutes();
	var s=date.getSeconds();
	var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;
	// Convert real date parts into formatted versions
	var value=new Object();
	if (y.length < 4) {y=""+(y-0+1900);}
	value["y"]=""+y;
	value["yyyy"]=y;
	value["yy"]=y.substring(2,4);
	value["M"]=M;
	value["MM"]=cbeDateBox_LZ(M);
	value["MMM"]=MONTH_NAMES[M-1];
	value["NNN"]=MONTH_NAMES[M+11];
	value["d"]=d;
	value["dd"]=cbeDateBox_LZ(d);
	value["E"]=DAY_NAMES[E+7];
	value["EE"]=DAY_NAMES[E];
	value["H"]=H;
	value["HH"]=cbeDateBox_LZ(H);
	if (H==0){value["h"]=12;}
	else if (H>12){value["h"]=H-12;}
	else {value["h"]=H;}
	value["hh"]=LZ(value["h"]);
	if (H>11){value["K"]=H-12;} else {value["K"]=H;}
	value["k"]=H+1;
	value["KK"]=cbeDateBox_LZ(value["K"]);
	value["kk"]=cbeDateBox_LZ(value["k"]);
	if (H > 11) { value["a"]="PM"; }
	else { value["a"]="AM"; }
	value["m"]=m;
	value["mm"]=cbeDateBox_LZ(m);
	value["s"]=s;
	value["ss"]=cbeDateBox_LZ(s);
	while (i_format < format.length) {
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		if (value[token] != null) { result=result + value[token]; }
		else { result=result + token; }
		}
	return result;
	}
	
// ------------------------------------------------------------------
// Utility functions for parsing in getDateFromFormat()
// ------------------------------------------------------------------
function cbeDateBox__isInteger(val) {
	var digits="1234567890";
	for (var i=0; i < val.length; i++) {
		if (digits.indexOf(val.charAt(i))==-1) { return false; }
		}
	return true;
	}
function cbeDateBox__getInt(str,i,minlength,maxlength) {
	for (var x=maxlength; x>=minlength; x--) {
		var token=str.substring(i,i+x);
		if (token.length < minlength) { return null; }
		if (cbeDateBox__isInteger(token)) { return token; }
		}
	return null;
	}
	
// ------------------------------------------------------------------
// getDateFromFormat( date_string , format_string )
//
// This function takes a date string and a format string. It matches
// If the date string matches the format string, it returns the 
// getTime() of the date. If it does not match, it returns 0.
// ------------------------------------------------------------------
function cbeDateBox_getDateFromFormat(val,format,m_switch) {
	val=val+"";
	format=format+"";
	var i_val=0;
	var i_format=0;
	var c="";
	var token="";
	var token2="";
	var x,y;
	var now=new Date();
	var year=now.getYear();
	var month=now.getMonth()+1;
	var date=1;
	var hh=now.getHours();
	var mm=now.getMinutes();
	var ss=now.getSeconds();
	var ampm="";
	var date_return = new Array();
	var d_switch = 0;
	if (m_switch == 1) {
		d_switch = 1;
	}
	
	while (i_format < format.length) {
		// Get next token from format string
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		// Extract contents of value based on format token
		if (token=="yyyy" || token=="yy" || token=="y") {
			if (token=="yyyy") { x=4;y=4; }
			if (token=="yy")   { x=2;y=2; }
			if (token=="y")    { x=2;y=4; }
			year=cbeDateBox__getInt(val,i_val,x,y);
			if (year==null) { return 0; }
			i_val += year.length;
			if (year.length==2) {
				if (year > 70) { year=1900+(year-0); }
				else { year=2000+(year-0); }
				}
			}
		else if (token=="MMM"||token=="NNN"){
			month=0;
			for (var i=0; i<MONTH_NAMES.length; i++) {
				var month_name=MONTH_NAMES[i];
				if (val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()) {
					if (token=="MMM"||(token=="NNN"&&i>11)) {
						month=i+1;
						if (month>12) { month -= 12; }
						i_val += month_name.length;
						break;
						}
					}
				}
			if ((month < 1)||(month>12)){return 0;}
			}
		else if (token=="EE"||token=="E"){
			for (var i=0; i<DAY_NAMES.length; i++) {
				var day_name=DAY_NAMES[i];
				if (val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()) {
					i_val += day_name.length;
					break;
					}
				}
			}
		else if (token=="MM"||token=="M") {
			month=cbeDateBox__getInt(val,i_val,token.length,2);
			if(month==null||(month<1)||(month>12)){return 0;}
			i_val+=month.length;}
		else if (token=="dd"||token=="d") {
			date=cbeDateBox__getInt(val,i_val,token.length,2);
			if(date==null||(date<1)||(date>31)){return 0;}
			i_val+=date.length;}
		else if (token=="hh"||token=="h") {
			hh=cbeDateBox__getInt(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>12)){return 0;}
			i_val+=hh.length;}
		else if (token=="HH"||token=="H") {
			hh=cbeDateBox__getInt(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>23)){return 0;}
			i_val+=hh.length;}
		else if (token=="KK"||token=="K") {
			hh=cbeDateBox__getInt(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>11)){return 0;}
			i_val+=hh.length;}
		else if (token=="kk"||token=="k") {
			hh=cbeDateBox__getInt(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>24)){return 0;}
			i_val+=hh.length;hh--;}
		else if (token=="mm"||token=="m") {
			mm=cbeDateBox__getInt(val,i_val,token.length,2);
			if(mm==null||(mm<0)||(mm>59)){return 0;}
			i_val+=mm.length;}
		else if (token=="ss"||token=="s") {
			ss=cbeDateBox__getInt(val,i_val,token.length,2);
			if(ss==null||(ss<0)||(ss>59)){return 0;}
			i_val+=ss.length;}
		else if (token=="a") {
			if (val.substring(i_val,i_val+2).toLowerCase()=="am") {ampm="AM";}
			else if (val.substring(i_val,i_val+2).toLowerCase()=="pm") {ampm="PM";}
			else {return 0;}
			i_val+=2;}
		else {
			if (val.substring(i_val,i_val+token.length)!=token) {return 0;}
			else {i_val+=token.length;}
			}
		}
	// If there are any trailing characters left in the value, it doesn't match
	if (i_val != val.length) { return 0; }
	// Is date valid for month?
	if (month==2) {
		// Check for leap year
		if ( ( (year%4==0)&&(year%100 != 0) ) || (year%400==0) ) { // leap year
			if (date > 29){ return 0; }
			}
		else { if (date > 28) { return 0; } }
		}
	if ((month==4)||(month==6)||(month==9)||(month==11)) {
		if (date > 30) { return 0; }
		}
	// Correct hours value
	if (hh<12 && ampm=="PM") { hh=hh-0+12; }
	else if (hh>11 && ampm=="AM") { hh-=12; }
	var newdate=new Date(year,month-1,date,hh,mm,ss);
	if (d_switch == 1) {
		date_return[0] = year;
		date_return[1] = month-1;
		date_return[2] = date;
		return date_return;
	}
	
	return newdate.getTime();
	}

// ------------------------------------------------------------------
// parseDate( date_string [, prefer_euro_format] )
//
// This function takes a date string and tries to match it to a
// number of possible date formats to get the value. It will try to
// match against the following international formats, in this order:
// y-M-d   MMM d, y   MMM d,y   y-MMM-d   d-MMM-y  MMM d
// M/d/y   M-d-y      M.d.y     MMM-d     M/d      M-d
// d/M/y   d-M-y      d.M.y     d-MMM     d/M      d-M
// A second argument may be passed to instruct the method to search
// for formats like d/M/y (european format) before M/d/y (American).
// Returns a Date object or null if no patterns match.
// ------------------------------------------------------------------
function cbeDateBox_parseDate(val, m_switch) {
	var preferEuro=(arguments.length==2)?arguments[1]:false;
	var d_switch = 0;
	if (m_switch == 1) {
		d_switch = 1;
	}
	generalFormats=new Array('y-M-d','MMM d, y','MMM d,y','y-MMM-d','d-MMM-y','MMM d');
	monthFirst=new Array('M/d/y','M-d-y','M.d.y','MMM-d','M/d','M-d');
	dateFirst =new Array('d/M/y','d-M-y','d.M.y','d-MMM','d/M','d-M');
	var checkList=new Array('generalFormats',preferEuro?'dateFirst':'monthFirst',preferEuro?'monthFirst':'dateFirst');
	var d=null;
	var d_ar = new Array();
	d_ar[0] = 0;
	for (var i=0; i<checkList.length; i++) {
		if (d_switch == 1) {
			var l=window[checkList[i]];
			for (var j=0; j<l.length; j++) {
				d_ar=cbeDateBox_getDateFromFormat(val,l[j],d_switch);
				if (d_ar[0]!=0) { return d_ar; }
			}
		} else if (d_switch == 0) {
			var l=window[checkList[i]];
			for (var j=0; j<l.length; j++) {
				d=cbeDateBox_getDateFromFormat(val,l[j],0);
				if (d!=0) { return new Date(d); }
			}
		}
				
		}
	return null;
	}

function cbeDateBox_checkDateRange(val,lowRange,highRange) {
	var cbe_today = new Date();
	var cbe_year = cbe_today.getFullYear();
	var val_m = new Date(cbeDateBox_parseDate(val));
		val_m = val_m.getFullYear();
	var lowRange_m = new Date(cbeDateBox_parseDate("01.01."+lowRange,0));
		lowRange_m = lowRange_m.getFullYear();
	if (highRange == '' || highRange == 0) {
		highRange = cbe_year;
	}
	var highRange_m = new Date(cbeDateBox_parseDate("31.12."+highRange,0));
		highRange_m = highRange_m.getFullYear();
	if (highRange_m == null) {
		highRange_m = cbeDateBox_parseDate("30.12."+highRange,0);
	}
	
	if ( lowRange_m <= val_m && val_m <= highRange_m ) {
		return true;
	} else {
		return false;
	}
}
// ------------------------------------------------------------------

function cbeDateBox_LY( c_year, c_type ) {
// Flag: liefert 1, wenn Schaltjahr, sonst 0
	var result;
	// gregorianischer Kalender
	// else  julianischer Kalender
	if ( c_type == "gregor" ) {
		result = ( ( c_year % 4 ) == 0 ) && ( ( ( c_year % 100 ) != 0 ) || ( ( c_year % 400 ) == 0 ) );
		return ( result );
	} else if (c_type=="julian") {
		result = ( ( c_year % 4 ) == 0 );
		return ( result );
	}
} 

//liefert die Tageszahl des angegebenen Monats im entsprechenden Jahr
function cbeDateBox_DpM( c_year, c_month, c_type ) {
	var dpm, result;
	c_type = "gregor";
	dpm = new Array( 31,28,31,30,31,30,31,31,30,31,30,31 );
	c_month--;
	result = dpm[ c_month ];
 	if ( c_month == 1 ) {
 		if ( cbeDateBox_LY ( c_year, c_type ) ) {
      			result++;
		}
	}
  	return ( result );
 }

//--------------------------------------------------------------------

//-->
</script>

EOT;

//	var d=cbeDateBox_parseDate(this.form.date5.value);
//	if(d==null){
//		alert('Date string doesn\'t match any recognized formats!');
//	} else {
//		this.form.output5.value=cbeDateBox_formatDate(d,'MMM dd, yyyy');
//	}

?>