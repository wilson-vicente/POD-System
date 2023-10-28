function login(form) {
	var xhr   = new XMLHttpRequest()
	var datos = new FormData(form)

	xhr.open("POST", form.action, true)

	xhr.onload = function() {
		if (this.response.exito) {
			window.location.href = base_url("");
		} else {
			document.getElementById("msgAlert").innerHTML = this.response.msg
			document.getElementById("msg").style.display = "block"
		}
	}

	xhr.responseType = "json"
	xhr.send(datos)

	return false;
}

function registro(form) {
	var xhr = new XMLHttpRequest()
	var datos = new FormData(form)

	xhr.open("POST", form.action, true)

	xhr.onload = function () {
		if (this.response.exito) {
			window.location.href = base_url("index.php/login")
		} else {
			notificar("ENC", this.response.msg)
		}
	}

	xhr.responseType = "json"
	xhr.send(datos)

	return false
}

function tamanioContrasenia(inp) {
	var pass = inp.value
	var ntf  = document.getElementById("valid-pass")
	ntf.removeAttribute("class");

	if (pass.length == 0) {
		ntf.innerHTML = "Debe ingresar una contraseña"
		ntf.setAttribute("class", "text-danger")
	}

	if (pass.length >= 1 && pass.length <= 4) {
		ntf.innerHTML = "Contraseña debil"
		ntf.setAttribute("class", "text-danger")
	}

	if (pass.length >= 5 && pass.length <= 7) {
		ntf.innerHTML = "Contraseña media"
		ntf.setAttribute("class", "text-warning")
	}

	if (pass.length >= 8) {
		ntf.innerHTML = "Contraseña aceptable"
		ntf.setAttribute("class", "text-success")
	}

	ntf.style.display = "block";
}