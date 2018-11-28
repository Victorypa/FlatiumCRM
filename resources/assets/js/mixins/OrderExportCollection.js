export default {
    data () {
        return {
            services: [],
            service_types: [],

            managers: [],
            manager_phones: [],
            manager_id: 1,
        }
    },

    mounted () {
        this.getServices()
        this.getServiceTypes()
        this.getManagers()
    },

    methods: {
        getManagers() {
            return axios.get(`/api/managers`)
                        .then(response => {
                            this.managers = response.data
                            response.data.forEach(item => {
                                this.manager_phones[item.id] = item.phone
                            })
                        })
        },

        sortServicesByCreatedAt (services) {
            if (services.length) {
                let data = _.orderBy(services, ['created_at'], ['asc'])

                return data
            }

        },

        groupByServiceType(services) {
            if (services.length) {
                return _.groupBy(services, 'service_type_id')
            }
        },

        priceCount (quantity, price) {
            return new Intl.NumberFormat('ru-Ru').format(parseInt(quantity) * price)
        },

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

        getServiceDetails (service_id, type) {
            if (this.services.length && service_id != null) {
                let data = this.services.filter(row => {
                    return row.id === parseInt(service_id)
                })

                switch (type) {
                    case 'name':
                        return data[0].name
                        break;
                    case 'unit':
                        return data[0].unit.name
                    case 'price':
                        return parseInt(data[0].price)
                    case 'can_be_discounted':
                        return data[0].can_be_discounted
                    default:
                        return null
                }
            }

        },

        getServiceTypeName (service_type_id) {
            if (this.service_types.length) {
                return this.service_types.filter(row => {
                    return row.id === parseInt(service_type_id)
                })[0].name
            }

        },

        getRoomDetails(room_id, type) {
            let data = this.rooms.filter(row => {
                return row.id === parseInt(room_id)
            })

            switch (type) {
                case 'description':
                     return data[0].description
                     break;

                case 'room_type':
                     return data[0].room_type.type
                     break;

                case 'room_type_id':
                        return data[0].room_type_id
                        break;

                case 'area':
                     return data[0].area
                     break;

                case 'height':
                     return data[0].height
                     break;

                case 'wall_area':
                     return data[0].wall_area
                     break;

                case 'perimeter':
                     return data[0].perimeter
                     break;

                default:
                    return null
            }
        },

    }
}
