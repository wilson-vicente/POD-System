Vue.component("select2", {
	template: `<select 
				class="form-control"
				v-bind:multiple="multiple">
			</select>`,
	props: {
		options: {
			Object
		},
		value: null,
		multiple: {
			Boolean,
			default: false
		},
		indice: null,
		campo: null,
		placeholder: null
	},
	data() {
		return {
			select2data: []
		}
	},
	mounted() {
		this.formatOptions()
		let vm = this
		let select = $(this.$el)
		select.select2({
			width: "100%",
			allowClear: true,
			data: this.select2data
		}).on("change", function () {
			vm.$emit("input", select.val())
		});

		if (this.value) {
			select.val(this.value).trigger("change")
		}
	},
	methods: {
		formatOptions() {
			this.select2data = [];

			if (!this.multiple) {
				this.select2data.push({
					id: "",
					text: (this.placeholder != null) ? this.placeholder : "----------"
				});
			}

			if (this.indice != null &&
				this.campo != null) {
				for (let key in this.options) {
					this.select2data.push({
						id: this.options[key][this.indice],
						text: this.options[key][this.campo]
					})
				}
			} else {
				this.select2data = this.options;
			}
		},
		actualizarValor() {
			if (this.multiple) {
				if ([...this.value].sort().join(",") !== [...$(this.$el).val()].sort().join(",")) {
					$(this.$el).val(this.value).trigger("change");
				}
			} else {
				$(this.$el)
				.val(this.value)
				.trigger("change");
			}
		}
	},
	watch: {
		options: function() {
			this.formatOptions();
			$(this.$el).empty().select2({data:this.select2data, width:"100%"});
			this.actualizarValor();
		},
		value: function() {
			this.actualizarValor();
		}
	},
	destroyed: function () {
		$(this.$el).off().select2("destroy")
	}
});