function abrirLink(args) {
	var xhr = new XMLHttpRequest()
	var url = base_url(args.url)
	verCargando("paraForm", 1);
	xhr.open("POST", url, true)
	xhr.onload = function () {
		document.getElementById("paraForm").innerHTML = this.responseText
	}

	xhr.send()
	return false
}

function cargarPalabras() {
	var xhr = new XMLHttpRequest()
	var url = base_url("index.php/palabras");
	verCargando("paraPalabras", 1);
	xhr.open("POST", url, true)
	xhr.onload = function () {
		document.getElementById("paraPalabras").innerHTML = this.responseText
	}

	xhr.send()
	return false;
}

//cargarPalabras()