Vue.prototype.urlBase  = "/pod/index.php/ingreso"

Vue.directive("focus", {
    inserted: function(el, binding) {
        el.focus()
    },
    updated: function(el, binding) {
        if (binding.value) {
            el.focus()
        } else {
            el.blur()
        }
    }
})


var appIngreso = new Vue({
    el: "#appIngreso",
    data: {
        id_ingreso: 0,
        id_articulo: 0,
        idDetalleIngreso: 0,
        fecha_vencimiento: "",
        codigo: "",
        fecha: "",
        cantidad: 0,
        nombre: "",
        estadoiIngreso: 0,
        codigoArticulo: "",
        actualizarDetalle: false,
        verForm: false,
        verLista: false,
        btnBuscar: false,
        cargando: false,
        errores: null,
        mensaje: null,
        items: [],
        detalleItems: [],
        form: {},
        bform: {}
    },
    methods: {
        buscarCodigo: function () {

            this.id_articulo = 0;
            this.estadoiIngreso = 0;
            this.nombre = "";
            this.estadoiIngreso = 0;
            this.codigoArticulo = "";

            let data = {
                codigo: this.codigo
            }

            axios
            .post(`/pod/index.php/escaner/buscar`, data)
            .then(res => {
                console.log("yes");
                this.id_articulo = res.data.id;
                this.estadoiIngreso = res.data.estado;
                this.nombre = res.data.descripcion;
                this.estadoiIngreso = this.form.estado;

                this.limpiarMensaje();

            })
            .catch(error => {
                if (error.response && error.response.data.errores) {
                    this.errores = error.response.data.errores
                    this.mensaje = null
                    this.codigo  = ""
                    this.nombre  = ""
                } else {
                    this.errores = error.message
                    this.mensaje = null
                    this.codigo  = ""
                    this.nombre  = ""
                }
            })
        
        },
        guardarDetalleingreso: function () {

            let data = {
                idDetalleIngreso: this.idDetalleIngreso,
                id_ingreso: this.id_ingreso,
                id_articulo: this.id_articulo,
                fecha_vencimiento: this.fecha_vencimiento,
                cantidad: this.cantidad,
                codigo: this.codigo
            }

            axios
            .post(`${this.urlBase}/guardarDetalleIngreso`, data)
            .then(res => {

                if(this.actualizarDetalle == true) {

                    $("#mdlVerDetalleIngreso").modal();
                    $("#mdlDetalleIngreso").modal("hide");
                    this.verDetalleIngreso(this.id_ingreso);

                } 

                this.mensaje = res.data.mensaje;

                this.id_articulo = 0
                this.fecha_vencimiento =""
                this.codigo = ""
                this.cantidad = 0
                this.nombre = ""

            })
            .finally(() => { this.btnNuevo = false})
            .catch( error => {
                if (error.response && error.response.data.errores) {
                    this.errores  = error.response.data.errores;
                    
                    this.id_articulo = 0
                    this.fecha_vencimiento =""
                    this.codigo = ""
                    this.cantidad = 0
                    this.nombre = ""

                } else {
                    this.errores = error.message;

                    this.id_articulo = 0
                    this.fecha_vencimiento =""
                    this.codigo = ""
                    this.cantidad = 0
                    this.nombre = ""
                }
            })

        },
        nuevo: function () {
			this.limpiarMensaje()
            this.verForm   = false
            this.verLista  = false
            this.id_ingreso = 0
            this.id_articulo = 0
            this.fecha_vencimiento =""
            this.codigo = ""
            this.cantidad = 0
            this.nombre = ""
            this.estadoiIngreso = 0

            axios
            .post(`${this.urlBase}/generarIngreso`)
            .then(res => {

                this.mensaje        = res.data.mensaje;
                this.estadoiIngreso = res.data.reg.estado;
                this.form           = res.data.reg;
                this.verForm        = true;
                //this.form = res.data.reg[0];
            })
            .finally(() => { this.btnNuevo = false})
            .catch( error => {
                if (error.response && error.response.data.errores) {
                    this.errores  = error.response.data.errores;
                    this.verForm  = false;
                } else {
                    this.errores = error.message;
                    this.verForm = false;
                }
            })
		},
        getDatos: function () {
            this.cargando = true
        },
        limpiarMensaje: function () {
			this.errores    = null
			this.mensaje    = null
		},
        buscar: function () {

            this.verForm   = false
            this.verLista  = true
            this.errores   = null
            this.mensaje   = null

            this.id_ingreso = 0
            this.id_articulo = 0
            this.fecha_vencimiento =""
            this.codigo = ""
            this.cantidad = 0
            this.nombre = ""

            axios
            .post(`${this.urlBase}/buscarIngreso`, this.bform)
            .then(res => {
                this.items = res.data.reg;
            })
            .finally(() => { this.btnNuevo = false})
            .catch( error => {
                if (error.response && error.response.data.errores) {
                    this.errores = error.response.data.errores;
                }
            })

		},
        limpiarMensaje: function () {
            this.errores    = null
            this.mensaje    = null
        },
        cerrar: function () {
            
            this.limpiarMensaje()
            this.verForm    = false
            this.errores    = null
            this.mensaje    = null

            this.id_ingreso = 0
            this.id_articulo = 0
            this.fecha_vencimiento =""
            this.codigo = ""
            this.cantidad = 0
            this.nombre = ""
        },
        actualizarIngreso: function () {
            axios
            .post(`${this.urlBase}/actualizarIngreso`, this.form)
            .then(res => {
                this.estadoiIngreso = this.form.estado;
                this.mensaje = res.data.mensaje;
            })
            .finally(() => { this.btnNuevo = false})
            .catch( error => {
                if (error.response && error.response.data.errores) {
                    this.errores = error.response.data.errores;
                }
            })
        },
        editar: function (idx) {
            let item = this.items[idx]
            this.form  = item

            this.estadoiIngreso = item.estado;

            this.verForm  = true
            this.verLista = false

            this.errores    = null
            this.mensaje    = null
        },
        agregarDetalle: function (id) {
            this.id_ingreso = id;
            $("#mdlDetalleIngreso").modal();
            this.limpiarMensaje();
        },
        cerrarModal: function () {
            $("#mdlDetalleIngreso").modal("hide");
            this.limpiarMensaje();
        },
        verDetalleIngreso: function (xid) {

             let data = {
                id_ingreso: xid
            }

            axios
            .get(`${this.urlBase}/obtenerDetalleIngreso`, {params: data})
            .then(res => {  
                this.detalleItems = res.data
            })
            .finally(() => { this.btnBuscar = false })
            .catch(e => {
                alert(e.message)
            })

            $("#mdlVerDetalleIngreso").modal();
        },
        cerrarModalDetalleIngreso: function () {
            $("#mdlVerDetalleIngreso").modal("hide");
            this.limpiarMensaje();
        },
        eliminarItem: function (k, key, idIngreso) {

            let data = {
                id: key,
                idingreso: idIngreso
            }

            axios
            .post(`${this.urlBase}/eliminarDetalleIngreso`, data)
            .then(res => {

                if (res.data.mensaje != "") {
                    this.detalleItems.splice(k, 1);
                    this.mensaje = res.data.mensaje; 
                }

            })
            .finally(() => { this.btnNuevo = false})
            .catch( error => {
                if (error.response && error.response.data.errores) {
                    this.errores = error.response.data.errores;
                }
            })
        },
        editarDetalleIngreso: function (idx) {
            $("#mdlVerDetalleIngreso").modal("hide");
            $("#mdlDetalleIngreso").modal();

            this.idDetalleIngreso = idx.id;
            this.codigo = idx.codigo;
            this.nombre = idx.descripcion;
            this.fecha_vencimiento = idx.fecha_vencimiento;
            this.cantidad = idx.cantidad;
            this.id_ingreso = idx.id_ingreso;
            this.id_articulo = idx.id_articulo;
            this.codigoArticulo = idx.codigo;
            this.actualizarDetalle = true; 

            this.limpiarMensaje();
        },
    }
   
})