


window.onload = () => {

    // prepara todos los formularios
    let form = document.getElementsByTagName("form");
        for (let i = 0; i < form.length; i++) {
            form[i].onsubmit = (e) => {
                e.preventDefault();
                if (form[i].ajax_url) {
                    let data = new FormData(form[i]);
                        data.delete('ajax_url');
                        sendAjax(data, form[i].ajax_url);
                } else {
                    form[i].submit();
                }
            };
        }

};








function sendAjax(data, url) {
    
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {

		if(this.readyState == 4 && this.status == 200){
			
            let response = JSON.parse(this.responseText);
            alert(response);

		}else{

            alert("error ajax:" + url);

		}
		
	};
	xhttp.open("POST", url, true);
	xhttp.send(data);

}
