<template>
    <section class="create-floor-work">
        <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">

            <navigation></navigation>

          <div class="col-md-10 bg px-0">
            <div class="container-fluid px-0">

                <ServiceDetail v-if="service.length !== 0"
                              :service="service"
                              />


              <div class="row create-floor-work__content px-15">
                <div class="col-10">
                    <div class="input-group">
                      <input class="form-control py-2"
                             placeholder="Введите навание материала"
                             v-model="searchQuery"
                             >
                    </div>
                </div>

                <div class="col-2">
                    <button type="button"
                            class="btn btn-link"
                            @click="handle()"
                            >
                        Чистить
                    </button>
                </div>
              </div>

              <div class="row pt-4">
                  <AddMaterial />

                  <RoomServiceMaterial v-if="room_service.materials.length !== 0"
                                       v-for="material in room_service.materials"
                                       :material="material"
                                       :material_units="material_units"
                                       :key="'room-service-material-' + material.id"
                                       @removed-material="handle()"
                                       />

                  <Material v-if="filteredMaterials.length !== 0"
                            v-for="material in filteredMaterials"
                            :material="material"
                            :material_units="material_units"
                            :key="material.id"
                            @added-material="handle()"
                            />
              </div>

            </div>

          </div>
        </div>

      </div>

    </section>
</template>

<script>
    import ServiceDetail from '@/components/Services/Materials/partials/ServiceDetail'
    import AddMaterial from '@/components/Services/Materials/partials/AddMaterial'
    import Material from './partials/Material'
    import RoomServiceMaterial from './partials/RoomServiceMaterial'

    export default {
        data () {
            return {
                service: [],
                room_service: [],
                searchQuery: '',
                material_units: []
            }
        },

        created () {
            this.getMaterialUnits()
            this.getService()
            this.getCurrentRoomService()
        },

        components: {
            ServiceDetail, AddMaterial,
            Material, RoomServiceMaterial
        },

        methods: {
            getService () {
                return axios.get(`/api/services/${this.$route.params.service_id}`)
                            .then(response => {
                                this.service = response.data
                            })
            },

            getCurrentRoomService () {
                return axios.get(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/${this.$route.params.service_id}/show`)
                            .then(response => {
                                this.room_service = response.data
                            })
            },

            getMaterialUnits () {
                if (localStorage.getItem('material_units')) {
                    this.material_units = JSON.parse(localStorage.getItem('material_units'))
                } else {
                    return axios.get(`/api/material_units`).then(response => {
                        localStorage.setItem('material_units', JSON.stringify(response.data))
                        this.material_units = response.data
                    })
                }
            },


            handle () {
                this.searchQuery = ''
                this.getService()
                this.getCurrentRoomService()
            }
        },

        computed: {
          filteredMaterials() {
              if (this.service.length !== 0) {
                  let data = this.service.materials

                  let room_service_material_ids = []

                  if (this.room_service.length !== 0) {
                      this.room_service.materials.forEach(room_service_material => {
                          room_service_material_ids.push(room_service_material.id)
                      })

                      data = data.filter(row => {
                          return room_service_material_ids.indexOf(row.id) < 0
                      })
                  }

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
          }
        }
    }
</script>

<style scoped lang="scss">
$main-color: #00A4D1;

.main-caption {
  &::after {
    display: none;
  }
}

.add-button {
   background-color: transparent;
   border: none;
   cursor: pointer;
   &:focus {
     outline: none;
   }
   img {
     width: 35px;
     border-radius: 50%;
     &:hover {
       box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
     }
   }
   &--remove {
     color: #ccc;
     &:hover {
       color: $main-color;
     }
     img {
       width: 15px;

     }
   }
 }

 .service-input {
     outline: 0;
     border-width: 0 0 2px;
     &:focus {
         outline: none !important;
         border-width: 0 0 2px !important;
     }
 }
</style>
