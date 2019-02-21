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

             <div class="col-md-12 px-0 all-items"
                  v-for="extra_room_service in filteredExtraRoomServices"
                  >
                     <ExtraRoomService :extra_room_service="extra_room_service"
                                  :extra_room="extra_room"
                                  :key="extra_room_service.service_id"
                                  />
             </div>

         </div>
    </div>
</template>

<script>
    import AddService from '@/components/Services/partials/AddService'
    import ExtraRoomService from './partials/ExtraRoomService'

    export default {
        props: ['extra_room'],

        data () {
            return {
                service_type_id: 1,
                service_types: [],
                searchQuery: ''
            }
        },

        components: {
            AddService, ExtraRoomService
        },

        created () {
            this.getServiceTypes()
        },

        methods: {
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

            getServiceTypeName (service_type_id) {
                if (this.service_types.length) {
                    return this.service_types.filter(row => {
                        return row.id === this.service_type_id
                    })[0].name
                }
            }
        },

        computed: {
            filteredExtraRoomServices () {
                if (this.extra_room.length !== 0) {
                    let data = this.extra_room.extra_room_services

                    data = data.filter(row => {
                        return row.service_type_id === this.service_type_id
                    })

                    return data
                }
            }
        }
    }
</script>
