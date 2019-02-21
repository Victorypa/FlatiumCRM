<template>
    <div class="row align-items-center col-12 py-4 fixed-search">
        <div class="col-2 pb-2">
            <select class="form-control" v-model="service_type_id">
                  <option v-for="service_type in service_types" :value="service_type.id">
                      {{ service_type.name }}
                  </option>
            </select>
        </div>

        <div class="col-10 d-flex align-items-center pl-0 pb-2">
            <div class="form-group col-12 d-flex align-items-center">
                <input type="text"
                       class="form-control"
                       placeholder="Название вида работы"
                       v-model="searchQuery"
                       autofocus
                       >
            </div>
        </div>

        <div class="col-12">
            <AddService :service_type_id="service_type_id"
                        @created-service="getServices()"
                        />
        </div>


        <div class="col-12 pr-0"
             style="margin-bottom: 5em;"
             v-if="service_type_id !== 0"
             >

             <div class="main-subtitle main-subtitle--fz pt-3 pb-2">
                 {{ getServiceTypeName(service_type_id) }}
             </div>

             <!-- <div class="col-md-12 px-0 all-items"
                  v-for="extra_room_service in filteredExtraRoomServices"
                  >
                     <ExtraRoomService :extra_room_service="extra_room_service"
                                  :extra_room="extra_room"
                                  :key="extra_room_service.service_id"
                                  />
             </div> -->

             <div class="col-md-12 px-0 all-items"
                  v-for="service in filteredServices"
                  >

                  <Service :service="service"
                           :room="extra_room"
                           :key="service.id"
                           />
             </div>

         </div>
    </div>
</template>

<script>
    import ServiceCollection from '@/components/Services/mixins/ServiceCollection'
    import AddService from '@/components/Services/partials/AddService'
    import ExtraRoomService from './partials/ExtraRoomService'
    import Service from '@/components/Orders/Rooms/Services/partials/Service'

    export default {
        mixins: [ServiceCollection],

        data () {
            return {
                room: [],
                extra_room: [],
                service_types: [],
                service_type_id: 1,

                searchQuery: ""
            }
        },

        components: {
            AddService, ExtraRoomService, Service
        },

        created () {
            this.getExtraRoomServices()
        },

        methods: {
            getExtraRoomServices () {
                axios.get(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_act_id}/extra_rooms/${this.$route.params.extra_room_id}`)
                     .then(response => {
                         this.extra_room = response.data
                     })
            },

            getServiceTypeName (service_type_id) {
                if (this.service_types.length !== 0) {
                    return this.service_types.filter(row => {
                        return row.id === this.service_type_id
                    })[0].name
                }
            }
        },

        computed: {
            filteredServices () {
                if (this.services.length !== 0 && this.extra_room.length !== 0) {
                    let data = this.services

                    let extra_room_service_ids = []

                    this.extra_room.extra_room_services.forEach(extra_room_service => {
                        extra_room_service_ids.push(extra_room_service.service_id)
                    })

                    data = data.filter(row => {
                        return extra_room_service_ids.indexOf(row.id) < 0
                    })

                    data = data.filter(row => {
                        return row.service_type_id === this.service_type_id
                    })

                    data = data.filter(row => {
                      return Object.keys(row).some(key => {
                        return (
                          String(row[key])
                            .toLowerCase()
                            .indexOf(this.searchQuery.toLowerCase()) > -1
                        )
                      })
                    })

                    return data
                }
            },

            filteredExtraRoomServices () {
                    let data = this.extra_room.extra_room_services

                    data = data.filter(row => {
                        return row.service_type_id === this.service_type_id
                    })

                    return data

            }
        }
    }
</script>
