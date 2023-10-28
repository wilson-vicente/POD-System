Vue.prototype.urlBase = "/pod/index.php/reporte/venta"

var AppRepGanancia = new Vue({
	el: "#AppRepGanancia",
	data: {
		cargando: false,
		btnBuscar: false,
		mostrar: false,
		tempTd: null,
		bform: {},
		items: [],
		cat: {
			tipo: [],
			sub_tipo: [],
			venta_tipo: []
		}
	},
	created: function () {
		var now = new Date();
    	now.setMinutes(now.getMinutes() - now.getTimezoneOffset());

		this.bform.fdel       = now.toJSON().slice(0, 10);
		this.bform.fal        = now.toJSON().slice(0, 10);
		this.bform.venta_tipo = 1;
		
		this.getDatos();
	},
	methods: {
		getDatos: function () {
			this.cargando = true
			
			axios
			.get(`${this.urlBase}/get_datos_ganancia`)
			.then(res => {
				this.cat = res.data
			})
			.finally(() => { this.cargando = false })
			.catch(e => {
				alert(e.message)
			})
		},
		buscar: function () {
			this.btnBuscar = true
			this.tempTd    = null
			this.items     = []
			
							
			axios
			.post(`${this.urlBase}/ganancia`, this.bform)
			.then(res => {
				this.items = res.data
			})
			.finally(() => { this.btnBuscar = false })
			.catch(e => {
				alert(e.message)
			})
		},
		reporteListo: function () {
			this.btnBuscar = false
		},
		mostrarForm: function (valor) {
			this.mostrar = valor
		}
	},
	computed: {
		getSubTipo: function () {
			return this.cat.sub_tipo.filter(o => {
				return o.id_tipo_articulo == this.bform.tipo
			})
		},
		getTotalVenta: function () {

			return parseFloat(this.items
						.map((item) => {
							
							if (item.monto_venta > 0) {
								return item.monto_venta;
							} else {
								return 0;
							}
							
						})	// Obtenemos los valores de los objetos Venta
						.reduce(
							(a, b) => parseFloat(a) + parseFloat(b), 0 // Sumamos los valores
						)
					).toFixed(2); 		
		},
		getTotalCosto: function () {

			return parseFloat(this.items
						.map((item) => {
							
							if (item.monto_costo > 0) {
								return item.monto_costo;
							} else {
								return 0;
							}
							
						})	// Obtenemos los valores de los objetos Venta
						.reduce(
							(a, b) => parseFloat(a) + parseFloat(b), 0 // Sumamos los valores
						)
					).toFixed(2); 		
		},

		getResultadoPerdidaGanancia: function() {
			return parseFloat(parseFloat(this.getTotalVenta) - parseFloat(this.getTotalCosto)).toFixed(2);
		},

		getTotalGanancia: function () {

			return parseFloat(this.items
						.map((item) => {
							
							if (item.ganancia > 0) {
								return item.ganancia;
							} else {
								return 0;
							}
							
						})	// Obtenemos los valores de los objetos Venta
						.reduce(
							(a, b) => parseFloat(a) + parseFloat(b), 0 // Sumamos los valores
						)
					).toFixed(2); 		
		},
		getTotalPerdida: function() {
			return parseFloat(this.items
						.map((item) => {
							if (item.venta_tipo_id == 2) {
								return item.ganancia;
							} else {
								return 0;
							}
						})	// Obtenemos los valores de los objetos Venta
						.reduce(
							(a, b) => parseFloat(a) + parseFloat(b), 0 // Sumamos los valores
						)
					).toFixed(2);
		},
		getTotalResumen: function() {
			return parseFloat(parseFloat(this.getTotalGanancia) - parseFloat(this.getTotalPerdida)).toFixed(2);
		}

	},
	watch: {
		tempTd: function(){
			if (this.items.length > 0 && (document.getElementsByClassName("trTablaGanancia").length == this.items.length)) {
				$("#tblRepGanancia").DataTable({
					destroy: true,
					dom: "Bfrtip",
					buttons: [
						"excel",
						"pdf"
					]
				})
			}
		}
	}
})