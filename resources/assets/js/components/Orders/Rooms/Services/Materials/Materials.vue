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
                <div class="col-12">
                    <div class="input-group">
                      <input class="form-control py-2"
                             placeholder="Введите навание материала"
                             v-model="searchQuery"
                             >
                    </div>
                </div>
              </div>

              <!-- <div class="row pt-4">

                  <form @submit.prevent="saveNewMaterial()" class="col-12 px-0">

                      <div class="row justify-content-between align-items-center col-12 pb-3" v-for="newMaterial in newMaterials">
                        <div class="col-6 pr-0">
                          <input type="text"
                                 class="form-control"
                                 placeholder="Наименование"
                                 v-model="newMaterial.name">
                        </div>

                          <div class="col-2 d-flex pr-0">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Цена"
                                   v-model="newMaterial.price"
                                   >

                            <input type="text"
                                   class="form-control ml-2"
                                   placeholder="Ед.уп"
                                   v-model="newMaterial.quantity"
                                   >
                         </div>

                            <div class="col-md-4 pl-0">
                              <div class="form-group d-flex align-items-center mb-0 justify-around">

                                <select class="form-control col-4 ml-2" v-model="newMaterial.material_unit_id">
                                  <option v-for="material_unit in material_units" :value="material_unit.id">
                                      {{ material_unit.name }}
                                  </option>
                              </select>

                                <input type="text"
                                       class="form-control col-3 ml-2"
                                       placeholder="Расход"
                                       v-model="newMaterial.rate"
                                       >

                                <template v-if="newMaterial.quantity && newMaterial.rate && newMaterial.price">
                                    <div class="total-sum col-3 text-right pr-0">
                                        {{ MaterialCalculation(newMaterial.quantity, newMaterial.rate, newMaterial.price, currentRoomService.quantity) }} Р
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="total-sum col-3 text-right pr-0">
                                        0 Р
                                    </div>
                                </template>
                              </div>
                            </div>
                          </div>

                          <div class="add-work" @click="addMaterial()">
                            +Добавить материал
                          </div>

                        <button type="submit" style="display: none;"></button>
                  </form>

                  <div class="row justify-content-between align-items-center col-12 py-1" v-for="material in filteredMaterials" :key="material.id">
                    <div class="col-6">
                      <div class="form-check">
                        <input class="form-check-input"
                               :id="'service-material-' + material.id"
                               type="checkbox"
                               :checked="room_service_material_ids.includes(material.id)"
                               @click="addServiceMaterialId(material.id)"
                               >

                        <label class="form-check-label"
                               :for="'service-material-' + material.id">
                               {{ material.name }}
                        </label>
                      </div>
                  </div>

                  <div class="col-2 d-flex pr-2 align-items-center justify-content-between py-2">
                      <div class="total-sum col-6">
                          {{ material.price }} Р
                      </div>

                      <input type="text"
                             class="form-control ml-2 col-6"
                             placeholder="Ед.уп"
                             v-model="service_material_quantities[material.id]"
                             @change="saveServiceMaterial()"
                             >
                   </div>

                   <div class="col-md-4 px-0">
                       <div class="form-group d-flex align-items-center mb-0 justify-around">

                          <select class="form-control col-4 ml-2" disabled>
                            <option :value="material.material_unit.id">
                                {{ material.material_unit.name }}
                            </option>
                          </select>

                          <input type="text"
                                 class="form-control col-3 ml-2"
                                 placeholder="Расход/м2"
                                 :id="'service-material-' + material.id"
                                 v-model="service_material_rates[material.id]"
                                 @change="saveServiceMaterial()"
                                 >

                        <div class="total-sum col-3 text-right pr-0">
                            <template v-if="service_material_quantities[material.id] && service_material_rates[material.id]">
                                {{ MaterialCalculation(service_material_quantities[material.id], service_material_rates[material.id], material.price, currentRoomService.quantity) }} Р
                            </template>
                            <template v-else>
                                0 Р
                            </template>
                        </div>

                        <template v-if="material.can_be_deleted">
                            <button @click="deleteMaterial(material.id)" class="add-button add-button--remove ml-auto" title="Удалить материал">
                                <img src="/img/del.svg" alt="add-button">
                            </button>
                        </template>
                        <template v-else>
                            &nbsp;
                        </template>
                      </div>
                    </div>
                  </div>

              </div> -->

            </div>

          </div>
        </div>

      </div>

    </section>
</template>

<script>
    import ServiceDetail from '@/components/Services/Materials/partials/ServiceDetail'
    // import ServiceMaterialCollection from '../../../../../mixins/ServiceMaterialCollection'

    export default {
        // mixins: [ServiceMaterialCollection],

        data () {
            return {
                service: [],
                searchQuery: ''

                
            }
        },

        created () {
            this.getService()
        },

        components: {
            ServiceDetail
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

                                // this.currentRoomService = response.data
                                // response.data.materials.forEach(material => {
                                //     this.room_service_material_ids.push(material.id)
                                // })
                            })
            },

            addServiceMaterialId (id) {
                if (!this.room_service_material_ids.includes(id)) {
                    this.room_service_material_ids.push(id)
                } else {
                    var index = this.room_service_material_ids.indexOf(id)

                    if (index > -1) {
                        this.room_service_material_ids.splice(index, 1)
                    }
                }

                this.saveServiceMaterial()
            },

            saveServiceMaterial () {
                axios.post(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/${this.$route.params.service_id}/materials/store`, {
                    'service_material_ids': this.room_service_material_ids,
                    'service_material_rates': this.removeEmptyElem(this.service_material_rates),
                    'service_material_quantities': this.removeEmptyElem(this.service_material_quantities),
                })
            },

            MaterialCalculation (quantity, rate, price, room_service_quantity) {
                let data = Math.ceil((rate * room_service_quantity) / quantity) * price
                return new Intl.NumberFormat('ru-Ru').format(parseInt(data))
            },
        },

        computed: {
          filteredMaterials() {
            let data = this.default_service_materials

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
