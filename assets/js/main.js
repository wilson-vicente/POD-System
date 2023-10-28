function base_url(url) {
	return window.location.origin + "/edwin/enc/" + url;
}
function verCargando(elementid, tipo) {
	var cont = document.getElementById(elementid)
	var txt  = ""

	switch(parseInt(tipo)){
		case 1:
			txt = "<p class='text-center spinner-border spinner-border-sm'></p>"
		break;
		case 2:
			txt = "<td colspan='100%' class='text-center spinner-border spinner-border-sm'></td>"
		break;
		default:
			txt = "<p class='text-center spinner-border spinner-border-sm'></p>"
		break;
	}

	if (cont) {
		cont.innerHTML = txt;
	}
}

$(document).on("click", ".btn-cerrar", function(){
	$(this).parents('.card').fadeOut();
});

function login() {
	var url = base_url("index.php/principal/login")

	cargarCuerpo({url:url})
}

function crearUsuario() {
	var url = base_url("index.php/principal/crear_usuario");
	
	cargarCuerpo({url:url})
}

function cargarData() {
	var url = base_url("index.php/palabras/")
	cargarCuerpo({url:url})
}

function notificar(titulo, msg) {
	var delay     = 5000 //tiempo de espera 5s
	var animation = true 
	var autohide  = true
	//var titulo    = "Alerta"
	//var msg       = "Alerta"
	var etitulo   = document.getElementById("tstHead")
	var ecuerpo   = document.getElementById("tstCuerpo")

	/*if (args.tm) {delay = args.tm}
	if (args.hide) {autohide = args.hide}
	if (args.title) {titulo = args.title}
	if (args.msg) {msg = args.msg}*/

	etitulo.innerHTML = titulo
	ecuerpo.innerHTML = msg

	$(".toast").toast({autohide:autohide, animation:animation, delay:delay})
	$(".toast").toast("show")
}

function cargarCuerpo(args) {
	var url  = args.url;
	var cls  = "script-agregado";
	var srp  = document.getElementsByClassName("script-agregado")
	var prin = document.getElementById("cuerpoPrincipal")

	while(srp.length > 0){
		srp[0].parentNode.removeChild(srp[0]);
	}

	var xhr = new XMLHttpRequest();
	xhr.onload = function() {

		var todos = this.response.scripts

		for (var i = 0; i < todos.length; i++) {
			var tag = document.createElement("script")

			if (todos[i].textContent !== '') {
				tag.textContent = todos[i].textContent
			} else {
				tag.src = todos[i].src
			}

			tag.className = cls
			document.body.appendChild(tag)
		}

		this.response.body.childNodes.forEach(function(i){
			if (i.nodeName === 'SCRIPT') {
				i.remove()
			}
		})

		prin.innerHTML = this.response.body.innerHTML
		
	}
	xhr.open("GET", url, 1)
	xhr.responseType = "document"
	xhr.send()
}

document.oncontextmenu = function () {
	return false
}

document.ondragstart = function () {
	return false
}