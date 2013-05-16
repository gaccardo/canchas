function trim(string) {
	string = string.replace(/^\s+/, '');
	for (var i = string.length; i > 0; i--) {
		if (/\S/.test(string.charAt(i))) {
			string = string.substring(0, i);
			break;
		}
	}
	return string;
}

function getElementLeft(Elem) {
	var elem = Elem;
	xPos = elem.offsetLeft;
	tempEl = elem.offsetParent;
 		while (tempEl != null) {
 			xPos += tempEl.offsetLeft;
  		tempEl = tempEl.offsetParent;
 		}
 		
	return xPos;
}


function getElementTop(Elem) {
	var elem = Elem;
	yPos = elem.offsetTop;
	tempEl = elem.offsetParent;
	while (tempEl != null) {
 			yPos += tempEl.offsetTop;
  		tempEl = tempEl.offsetParent;
 		}
	
	return yPos;
}

$(document).ready(function(){
	$.fn.clearForm = function() {
	  return this.each(function() {
	    var type = this.type, tag = this.tagName.toLowerCase();
	    if (tag == 'form')
	      return $(':input',this).clearForm();
	    if (type == 'text' || type == 'password' || tag == 'textarea')
	      this.value = '';
	    else if (type == 'checkbox' || type == 'radio')
	      this.checked = false;
	    else if (tag == 'select')
	      this.selectedIndex = -1;
	  });
	};
});

//function to show account settings dialog   
var showADialog = function() {

	//if the contents have been hidden with css, you need this
	jQuery('#dialogA').show(); 
	//open the dialog
	jQuery('#dialogA').dialog("open");

	var url = "controller.php?module=account_settings&action=edit";
	
	$.ajax({
	  url: url,
	  cache: false,
	  success: function(html){
	    $("#dialogA").html(html);
	    $("#account_settings").validate({
			rules: {
				first_name: "required",
				last_name: "required",
				username: "required",
				userpass: {
				      required: true,
				      minlength: 6
			    },
				userpasscheck: {
					equalTo: "#userpass",
					required: true,
					minlength: 6
				}
			}
		});
	  }
	});
	
}

//function to close account settings dialog, probably called by a button in the dialog
var closeADialog = function() {

	jQuery('#dialogA').dialog("close");
	
}

$(document).ready(function(){
 
	//start account settings     
    jQuery(".accountSettings").click( showADialog );

	//instantiate the dialog
	jQuery('#dialogA').dialog({ 
		height: 400,
		width: 600,
		modal: true,
		position: 'center',
		autoOpen:false,
		overlay: { 
			opacity: 0.5, 
			background: 'black'
		}
	});
	//end account settings
		
});
