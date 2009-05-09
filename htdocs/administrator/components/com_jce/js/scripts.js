// JavaScript Document
var jce = {
	getSelect : function(d, fn, v){
		var s = d.getElementById(fn);
		return s.value || false;
	},
	addSelect : function(d, fn, n, v){
		var s = d.getElementById(fn);		
		if(this.getSelect(d, fn, v) == n){
			return;
		}else{
			var o = new Option(n, v);
			s.options[s.options.length] = o;
		}
	},
	removeSelect : function(d, fn){
		var s = d.getElementById(fn);
		for(var i = s.length - 1; i>=0; i--){
    		if (s.options[i].selected) {
      			s.remove(i);
    		}
  		}
	}
}