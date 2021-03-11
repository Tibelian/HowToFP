
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


/**********************
* ACTUALIZA LA PÁGINA *
***********************/
function redirectHome() {
    showAlertRedirect();
    setTimeout(function() {
        window.location.href = WEB_URL;
    }, 3000);
}
function redirectAdmin() {
    showAlertRedirect();
    setTimeout(function() {
        window.location.href = WEB_URL + "/administrator";
    }, 3000);
}
function showAlertRedirect() {
    var text = "Serás redireccionado dentro de ";
    var container = document.getElementById("alert-container");
    var alert = document.createElement("div");
        alert.classList.add("alert", 'fade', 'show', "alert-info");
        alert.innerHTML = text + "3 segundos";
        container.appendChild(alert);
    setTimeout(function() {
        alert.innerHTML = text + "2 segundos";
    }, 1000);
    setTimeout(function() {
        alert.innerHTML = text + "1 segundo";   
    }, 2000);
    setTimeout(function() {
        alert.innerHTML = "HASTA LA VISTA BABY";
    }, 2999);
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










function refreshUploadsAndClear() {
    refreshUploads();
    document.getElementById('file-add-form').reset();
}

function refreshUploads() {

	var xhttp = getAjaxObject();
	xhttp.onreadystatechange = function() {

		if(this.readyState == 4 && this.status == 200) {
            try {

                var response = JSON.parse(this.responseText);
                if(response.status == 'error') {
                    showAlert("alert-warning", response.message);
                } else {

                    var fileList = document.getElementById("file-list");
                        fileList.innerHTML = "";
                    for(var i in response.data) {

                        fileList.innerHTML += `
                            <div class="col-md-6 col-lg-4 upload-file d-flex flex-column align-items-center bg-hover rounded">
                                <a href="${WEB_URL}/${response.data[i].path}" target="_blank">
                                    <img src="${WEB_URL}/${response.data[i].path}" width="100px" class="my-2">
                                </a>
                                <p class="m-0">Título: <strong>${response.data[i].basename}</strong></p>
                                <p class="m-0">Tamaño: <strong>${response.data[i].size} bytes</strong></p>
                                <p class="m-0">Descripción: <strong>${response.data[i].description}</strong></p>
                                <form method="post" action="#" class="my-2">
                                    <input type="hidden" name="ajax_url" value="${WEB_URL}/ajax/administrator/uploads/delete">
                                    <input type="hidden" name="callback" value="refreshUploads">
                                    <input type="hidden" name="id" value="${response.data[i].id}">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar archivo">Eliminar archivo <i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        `;

                    }

                    refreshAllForms();

                }

            } catch(e) {
                showAlert("alert-danger", e);
            }
		}
		
	};
	xhttp.open("get", WEB_URL + "/ajax/administrator/uploads/list", true);
	xhttp.send();

}