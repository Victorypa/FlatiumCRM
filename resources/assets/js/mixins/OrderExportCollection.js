export default {
    data () {
        return {
            managers: [],
            manager_phones: [],
            manager_id: 1,

            services: []
        }
    },

    mounted () {
        this.getServices()
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
            let data = _.orderBy(services, ['created_at'], ['asc'])

            return data
        },

        groupByServiceType(services) {
            return _.groupBy(services, 'service_type_id')
        },

        priceCount (quantity, price) {
            return new Intl.NumberFormat('ru-Ru').format(parseFloat(quantity * price).toFixed(2))
        },

        getServices () {
            return axios.get('/api/services').then(response => {
                this.services = response.data
            })
        },

        getServiceDetails (service_id, type) {
            if (this.services) {
                let data = this.services.filter(row => {
                    return row.id === parseInt(service_id)
                })

                if (data.length) {
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

            }

        },

        getServiceTypeName (service_type_id) {
            if (this.service_types && service_type_id) {
                return this.service_types.filter(row => {
                    return row.id === parseInt(service_type_id)
                })[0].name
            }

        },

        getRoomDetails(room_id, type) {
            if (this.rooms) {
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
