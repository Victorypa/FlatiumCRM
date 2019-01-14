export default {
    data () {
        return {
            service: [],
            default_service_materials: [],
            show: true,
            columnShow: false,
            service_name: '',
            service_price: null,

            material_units: [],

            newMaterials: [],
            searchQuery: '',
            materials: [],

            service_material_quantities: [],

            newMaterials: [],
        }
    },

    mounted () {
        this.getService()
        this.getMaterialUnits()
    },

    methods: {
        getService () {
            return axios.get(`/api/services/${this.$route.params.service_id}`)
                        .then(response => {
                            this.service = response.data
                            this.default_service_materials = response.data.materials
                            this.service_name = response.data.name
                            this.service_price = response.data.price

                            this.default_service_materials.forEach(material => {
                                this.service_material_quantities[material.id] = material.quantity
                            })
                        })
        },

        search () {
            axios.get(`/api/materials/search`, {
                params: { 'searchQuery': this.searchQuery }
            })
                .then(response => {
                    this.searchQuery = response.data.searchQuery
                    this.materials = response.data.materials

                    if (this.materials.length != 0) {
                        this.show = false

                        this.materials.forEach(item => {
                            this.service_material_quantities[item.id] = item.quantity
                            // this.service_material_rates[item.id] = item.pivot.rate

                        })
                    }
                })
        },

        getMaterialUnits () {
            if (localStorage.getItem('material_units')) {
                this.material_units = JSON.parse(localStorage.getItem('material_units'))
            } else {
                return axios.get(`/api/material_units`)
                            .then(response => {
                                this.material_units = response.data
                                localStorage.setItem('material_units', JSON.stringify(this.material_units))
                            })
            }

        },

        addServiceMaterialId (id) {
            if (!this.service_material_ids.includes(id)) {
                this.material_ids.push(id)
                this.service_material_ids.push(id)
            } else {
                var index2 = this.service_material_ids.indexOf(id)

                if (index2 > -1) {
                    this.service_material_ids.splice(index2, 1)
                }
            }
        },

        addMaterial () {
            this.newMaterials.push({
                name: null,
                flat_id: 1,
                material_unit_id: 1,
                price: null,
                quantity: null,
                rate: null
            })
        },

        saveNewMaterial () {
            this.newMaterials.forEach((item, index) => {
                return axios.post(`/api/materials/store`, {
                        'material_unit_id': item.material_unit_id,
                        'name': item.name,
                        'price': item.price,
                        'quantity': item.quantity,
                        'rate': item.rate,
                        'service': this.service
                    }).then(response => {
                        window.location.reload(true)
                    }).catch(err => {
                        console.log(err)
                    })
            })
        },

        removeEmptyElem(obj) {
            let newObj = {}

            Object.keys(obj).forEach((prop) => {
              if (obj[prop]) { newObj[prop] = obj[prop] }
            })

            return newObj
       },

       deleteMaterial (id) {
           if (confirm()) {
               axios.delete(`/api/materials/${id}/delete`).then(response => {
                   window.location.reload(true)
               })
           }
       },

       updateService () {
         if (this.service_name && this.service_price) {
           axios.patch(`/api/services/${this.$route.params.service_id}/update`, {
               'name': this.service_name,
               'price': this.service_price
           }).then(response => {
               this.show = true
               this.getService()
           })
         } else {
           alert('Заполняй пол')
           this.getService()
         }
       },

       showServiceInput () {
           this.columnShow = !this.columnShow
       },

       MaterialCalculation (quantity, rate, price) {
           let data = Math.ceil(rate/quantity) * price

           return parseFloat(data).toFixed(2)
       },
    }
}
