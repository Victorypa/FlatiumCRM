export default {
    data () {
        return {
            units: [],
            service_types: [],
            newServices: [],
            services: [],
            deleted: false
        }
    },

    created () {
        this.getServiceUnits()
        this.getServiceTypes()
        this.getServices()
    },

    methods: {
        getServices () {
            return axios.get('/api/services').then(response => {
                this.services = response.data
            })
        },

        addService () {
            this.newServices.push({
                unit_id: 1,
                service_type_id: this.service_type_id,
                name: null,
                price: null,
                can_be_discounted: false
            })
        },

        saveNewService () {
            this.newServices.forEach(item => {
                axios.post(`/api/services/store`, {
                    'service_type_id': this.service_type_id,
                    'name': item.name,
                    'unit_id': item.unit_id,
                    'price': item.price,
                    'can_be_discounted': item.can_be_discounted
                }).then(response => {
                    this.newServices = []
                    this.$emit('created-service')
                })
            })
        },

        deleteService (id) {
            if (confirm('Удалить ?')) {
                axios.delete(`/api/services/${id}/destroy`)
                     .then(response => {
                         this.deleted = !this.deleted
                         // this.$emit('deleted-service')
                     })
            }
        },

        getServiceUnits () {
            if (localStorage.getItem('units')) {
                this.units = JSON.parse(localStorage.getItem('units'))
            } else {
                return axios.get(`/api/units`)
                            .then(response => {
                                this.units = response.data
                                localStorage.setItem('units', JSON.stringify(this.units))
                            })
            }
        },

        getServiceTypes () {
            if (localStorage.getItem('service_types')) {
                this.service_types = JSON.parse(localStorage.getItem('service_types'))
            } else {
                return axios.get(`/api/service_types`).then(response => {
                    this.service_types = response.data
                    localStorage.setItem('service_types', JSON.stringify(this.service_types))
                })
            }
        },

        removeEmptyElem(obj) {
            let newObj = {}

            Object.keys(obj).forEach((prop) => {
              if (obj[prop]) { newObj[prop] = obj[prop] }
            })

            return newObj
       },
    }
}
