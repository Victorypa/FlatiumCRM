export default {
    data () {
        return {
            units: [],
            services: [],
            service_types: [],
        }
    },

    mounted () {
        this.getServices()
        this.getServiceTypes()
        this.getServiceUnits()
    },

    methods: {
        getServices () {
            return axios.get('/api/services').then(response => {
                this.services = response.data
            })
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
    }
}
