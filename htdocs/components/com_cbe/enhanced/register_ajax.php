<?php

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$register_ajax = <<<EOT
<!--
var req;
var target;
var isIE;

function initRequest(url) {
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        isIE = true;
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function validateUserId() {
    if (!target) target = document.getElementById("usrname");
    if (target.value != "") {

	var coll = document.mosForm_cbe;
	var r = new RegExp("_AXA_REGEXP", "i");
	var errorMSG = '';
	var iserror=0;
	if (coll.username.value.length < _AXA_USERNAMEMIN ||coll.username.value.length > _AXA_USERNAMEMAX) {
		setMessageUsingDOM("false");
		document.getElementById("submit_btn").disabled = true;
		iserror=2
	}
	if (r.exec(coll.username.value)) {
		errorMSG +=  "_AXA_ERRORUSRCODE";
		iserror=1;
	}
	if(iserror==1 || iserror==2) { 
		setMessageUsingDOM("format");
		document.getElementById("submit_btn").disabled = true;
		if (iserror==1) {
//			alert(errorMSG); 
		}
	} else {
    		var url = "index2.php?option=com_cbe&task=CheckUSRname&name=" + escape(target.value);    
    		initRequest(url);
    		req.onreadystatechange = processRequest;
    		req.open("GET", url, true); 
    		req.send(null);
	}
    } else {
    	document.getElementById("submit_btn").disabled = true;
    	setMessageUsingDOM("empty");
    }    	
}

function processRequest() {
    if (req.readyState == 4) {
        if (req.status == 200) {
            var Aussage = req.responseText;
            var message = "";
            Ergebnis1 = Aussage.search(/USRtest:false.+/);
            Ergebnis2 = Aussage.search(/USRtest:true.+/);
            Ergebnis3 = Aussage.search(/USRtest:empty.+/);
            if (Ergebnis1 != -1) {
            	message = "false";
            }
            if (Ergebnis2 != -1) {
            	message = "true";
            }
            if (Ergebnis3 != -1) {
            	message = "empty";
            }
            setMessageUsingDOM(message);
            var submitBtn = document.getElementById("submit_btn");
            if (message == "false" || message == "empty") {
              submitBtn.disabled = true;
            } else {
              submitBtn.disabled = false;
            }
        }
    }
}

function setMessageUsingInline(message) {
    mdiv = document.getElementById("userIdMessage");
    if (message == "false") {
       mdiv.innerHTML = "<div style=\"color:red\">_USEAJAX_FAIL_USR</div>";
    } else if (message == "true") {
       mdiv.innerHTML = "<div style=\"color:green\">_USEAJAX_TRUE_USR</div>";
    } else {
       mdiv.innerHTML = " ";
    }
}

 function setMessageUsingDOM(message) {
     var userMessageElement = document.getElementById("userIdMessage");
     var messageText;
     if (message == "false") {
         userMessageElement.style.color = "red";
         messageText = "_USEAJAX_FAIL_USR";
     } else if (message == "true") {
         userMessageElement.style.color = "green";
         messageText = "_USEAJAX_TRUE_USR";
     } else if (message == "format") {
     	 userMessageElement.style.color = "red";
         messageText = "_AXA_ERRORUSRCODE";
     } else {
	 userMessageElement.style.color = "black";
     	 messageText = " ";
     }
     var messageBody = document.createTextNode(messageText);
     // if the messageBody element has been created simple replace it otherwise
     // append the new element
     if (userMessageElement.childNodes[0]) {
         userMessageElement.replaceChild(messageBody, userMessageElement.childNodes[0]);
     } else {
         userMessageElement.appendChild(messageBody);
     }
 }

function disableSubmitBtn() {
    var submitBtn = document.getElementById("submit_btn");
    submitBtn.disabled = true;
}

-->
EOT;
?>