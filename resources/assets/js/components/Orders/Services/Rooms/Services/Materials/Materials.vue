<template>
    <section class="create-floor-work">
        <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">

            <navigation></navigation>

          <div class="col-md-10 bg px-0">
            <div class="container-fluid px-0">
                    <div class="create__fixed-top col-10 shadow-light">
                      <div class="row align-items-center ">

                          <template v-if="show">
                              <div class="col-md-8 d-flex align-items-end" @click="showServiceInput()">
                                <h2 class="main-caption col-8" v-if="service.name">
                                  {{ service.name}}
                                </h2>
                                <div class="main-subtitle ml-5">Цена: {{ service.price  }} Р</div>
                              </div>
                          </template>
                          <template v-else>
                              <div class="col-md-8 d-flex align-items-end" v-if="service_name" @mouseleave="showServiceInput()">
                                  <h2 class="main-caption col-auto">
                                      <input type="text"
                                             v-model="service_name"
                                             class="service-input"
                                             @change="updateService()"
                                             >
                                  </h2>

                                  <input type="number"
                                         class="service-input"
                                         v-model="service_price"
                                         @change="updateService()"
                                         />
                              </div>
                          </template>


                        <div class="col-md-4 text-right d-flex">
                            <button type="button"
                                    class="primary-button primary-button--outline col-6"
                                    @click="$router.go(-1)">
                              Назад
                            </button>

                            <button type="button"
                                    class="primary-button col-6 ml-2"
                                    @click="saveServiceMaterial()">
                                Сохранить
                            </button>
                        </div>

                      </div>
                    </div>


              <div class="row create-floor-work__content px-15">
                <form class="col-12" @submit.prevent="search()">
                  <div class="input-group">
                    <input class="form-control py-2"
                           placeholder="Введите навание материала"
                           v-model="searchQuery">
                    <i class="fa fa-search"></i>
                  </div>
                </form>
              </div>

              <div class="row pt-4">

                  <form @submit.prevent="saveNewMaterial()" class="col-12 px-0">

                      <div class="row justify-content-between align-items-center col-12 pb-3" v-for="newMaterial in newMaterials">
                        <div class="col-6 pr-0">
                          <input type="text"
                                 class="form-control"
                                 placeholder="Наименование"
                                 v-model="newMaterial.name">
                        </div>

                          <div class="col-2 d-flex pr-0">
                            <input type="number"
                                   class="form-control"
                                   placeholder="Цена"
                                   v-model="newMaterial.price"
                                   >

                            <input type="number"
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

                                <input type="number"
                                       class="form-control col-3 ml-2"
                                       placeholder="Расход"
                                       v-model="newMaterial.rate"
                                       >

                                <template v-if="newMaterial.quantity && newMaterial.rate && newMaterial.price">
                                    <div class="total-sum col-3 text-right pr-0">
                                        {{ MaterialCalculation(newMaterial.quantity, newMaterial.rate, newMaterial.price) }} Р
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



                  <template v-if="show">
                      <div class="row justify-content-between align-items-center col-12 py-1" v-for="material in service_materials" :key="material.id">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input"
                                   :id="'service-material-' + material.id"
                                   type="checkbox"
                                   :checked="true"
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
                                     >

                            <div class="total-sum col-3 text-right pr-0">
                                <template v-if="service_material_quantities[material.id] && service_material_rates[material.id]">
                                    {{ MaterialCalculation(service_material_quantities[material.id], service_material_rates[material.id], material.price, currentExtraRoomService.quantity) }} Р
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
                  </template>

                  <template v-else>
                      <div class="row justify-content-between align-items-center col-12 py-1" v-for="material in materials">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input"
                                   :id="'material-' + material.id"
                                   type="checkbox"
                                   :checked="service_material_ids.includes(material.id)"
                                   @click="addServiceMaterialId(material.id)"
                                   >

                            <label class="form-check-label"
                                   :for="'material-' + material.id">
                                {{ material.name }}
                            </label>
                          </div>
                      </div>

                      <div class="col-2 d-flex pr-2 align-items-center justify-content-between">
                          <div class="total-sum col-6">
                              {{ material.price }} Р
                          </div>

                          <input type="text"
                                 class="form-control ml-2 col-6"
                                 placeholder="Ед.уп"
                                 v-model="service_material_quantities[material.id]"
                                 >
                       </div>

                         <div class="col-md-4 px-0">
                             <div class="form-group d-flex align-items-center mb-0 justify-around">
                                 <select class="form-control col-4 ml-2" disabled>
                                   <option :value="material.material_unit_id">{{ material.material_unit.name }}</option>
                                 </select>

                                 <input type="text"
                                        class="form-control col-3 ml-2"
                                        placeholder="Расход/м2"
                                        :id="'material-' + material.id"
                                        v-model="service_material_rates[material.id]"
                                        >

                                <div class="total-sum col-3 text-right pr-0">
                                    <template v-if="service_material_quantities[material.id] && service_material_rates[material.id]">
                                        {{ MaterialCalculation(service_material_quantities[material.id], service_material_rates[material.id], material.price, currentExtraRoomService.quantity) }} Р
                                    </template>
                                    <template v-else>
                                        0 Р
                                    </template>
                                </div>
                          </div>
                        </div>
                      </div>

                  </template>


              </div>

            </div>

          </div>
        </div>

      </div>

    </section>
</template>

<script>
    import ServiceMaterialCollection from '../../../../../../mixins/ServiceMaterialCollection'

    export default {
        mixins: [ServiceMaterialCollection],

        data () {
            return {
                service_materials: [],
                service_material_ids: [],
                service_material_prices: [],
                service_material_rates: [],

                currentExtraRoomService: [],

                material_ids: [],

            }
        },

        mounted () {
            this.getActualServiceMaterials()
            this.getCurrentExtraRoomService()
        },

        methods: {
          getCurrentExtraRoomService () {
              return axios.get(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_services/${this.$route.params.service_id}/show`)
                          .then(response => {
                              this.currentExtraRoomService = response.data
                          })
          },

            getActualServiceMaterials () {
                return axios.get(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/services/${this.$route.params.service_id}/materials`)
                            .then(response => {
                                this.service_materials = response.data.actual_service_materials

                                response.data.actual_service_materials.forEach(item => {
                                    this.service_material_ids.push(item.id)
                                    this.service_material_prices[item.id] = item.price
                                    this.service_material_quantities[item.id] = item.quantity

                                    this.service_material_rates[item.id] = item.pivot.rate

                                })
                            })
            },

            saveServiceMaterial () {
                axios.post(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/services/${this.$route.params.service_id}/materials/store`, {
                    'service_material_ids': this.service_material_ids,
                    'service_material_rates': this.removeEmptyElem(this.service_material_rates),
                    'service_material_quantities': this.removeEmptyElem(this.service_material_quantities),
                }).then(response => {
                    window.location.reload(true)
                }).catch(err => {
                    console.log(err)
                })
            },

            MaterialCalculation (quantity, rate, price, room_service_quantity) {
              console.log(room_service_quantity);
                let data = Math.ceil((parseFloat(rate) * parseFloat(room_service_quantity)) / parseFloat(quantity)) * parseFloat(price)

                return new Intl.NumberFormat('ru-Ru').format(parseInt(data))
            },
        },


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
