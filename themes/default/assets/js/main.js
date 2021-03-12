
/*********************
 * DEFAULT VARIABLES *
 *********************/
 var WEB_URL = getCookie("url");          // WEBSITE URL
 var THEME_URL = getCookie("theme_url");  // CURRENT THEME URL


 window.onload = () => {

    refreshAllForms();

};
function refreshAllForms () {

    // prepara todos los formularios
    var form = document.getElementsByTagName("form");
    for (var i = 0; i < form.length; i++) {
        form[i].onsubmit = function(e) {

            e.preventDefault();
            var currentForm = e.currentTarget;

            if (currentForm.ajax_url) {

                var callback = null;
                var data = new FormData(currentForm);
                    data.delete('ajax_url');

                if (currentForm.callback) {
                    data.delete('callback');

                    var validationStr = currentForm.callback.value;
                    var cbFunction = window[validationStr];
                    if (typeof cbFunction === "function") {
                        callback = cbFunction;
                    }

                }

                sendAjax(data, currentForm.ajax_url.value, callback);

            } else {
                currentForm.submit();
            }
            
        };
    }

}


function sendAjax(data, url, callback = null) {

	var xhttp = getAjaxObject();
	xhttp.onreadystatechange = function() {

		if(this.readyState == 4 && this.status == 200) {
            try {

                var response = JSON.parse(this.responseText);
                if(response.status == 'error') {
                    showAlert("alert-warning", response.message);
                } else {

                    showAlert("alert-success", response.message);
                    if (callback != null) {
                        callback();
                    }

                }

            } catch(e) {
                showAlert("alert-danger", e);
            }
		}
		
	};
	xhttp.open("POST", url, true);
	xhttp.send(data);

}
function getAjaxObject(){
    if (window.XMLHttpRequest) {
        // code for modern browsers
        return new XMLHttpRequest();
    } else {
        // code for old IE browsers
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}


function clearContactForm() {
    var form = document.getElementById("contact-form");
        form.reset();
}


/****************************
* MOSTRAR ALERTAS DINÁMICAS *
*****************************/
function showAlert(css, msg, close = true){
    var container = document.getElementById("alert-container");
    var alert = document.createElement("div");
        alert.classList.add("alert", 'fade', 'show', css);
        alert.appendChild(document.createTextNode(msg));

    if(close){

        var button = document.createElement("button");
            button.classList.add("close");
            button.type = "button";
            button.setAttribute("data-dismiss", "alert");
            button.setAttribute("aria-label", "Close");

        var icon = document.createElement("i");
            icon.classList.add("fas", "fa-times");
        var span = document.createElement("span");
            span.setAttribute("aria-hidden", "true");
            span.appendChild(icon);

        button.appendChild(span);
        alert.classList.add("alert-dismissible");
        alert.appendChild(button);

    }
    container.appendChild(alert);
}


/************************
* GESTIONAR LAS COOKIES *
*************************/
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

