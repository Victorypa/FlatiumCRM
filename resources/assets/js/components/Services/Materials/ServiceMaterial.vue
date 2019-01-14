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

                          <template v-if="!columnShow">
                              <div class="col-md-8 d-flex align-items-end" @click="showServiceInput()">
                                <h2 class="main-caption col-8" v-if="service.name">
                                  {{ service.name}}
                                  <img src="/img/edit.svg" alt="add-button" title="Редактировать">
                                </h2>
                                <div class="main-subtitle ml-5">
                                    Цена: {{ service.price  }} Р
                                    <img src="/img/edit.svg" alt="add-button" title="Редактировать">
                                </div>
                              </div>
                          </template>
                          <template v-else>
                              <div class="col-md-8 d-flex align-items-center" v-if="service_name" @mouseleave="showServiceInput()">
                                  <h2 class="main-caption col-8">
                                      <input type="text"
                                             v-model="service_name"
                                             class="service-input w-100"
                                             @change="updateService()"
                                             required
                                             >
                                  </h2>

                                  <input type="number"
                                         class="service-input service-input--height col-2"
                                         v-model="service_price"
                                         @change="updateService()"
                                         required
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
                      <div class="row justify-content-between align-items-center col-12 py-2" v-for="material in service_materials" :key="material.id">
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
                                    {{ MaterialCalculation(service_material_quantities[material.id], service_material_rates[material.id], material.price) }} Р
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
                      <div class="row justify-content-between align-items-center col-12" v-for="material in materials">
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
                                        {{ MaterialCalculation(service_material_quantities[material.id], service_material_rates[material.id], material.price) }} Р
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
    import ServiceMaterialCollection from '../../../mixins/ServiceMaterialCollection'

    export default {
        mixins: [ServiceMaterialCollection],

        data () {
            return {
                service_materials: [],
                service_material_ids: [],
                service_material_prices: [],
                service_material_rates: [],
                service_material_quantities: [],
                show: false,
                service_name: '',
                service_price: null,

                newMaterials: [],
                searchQuery: '',
                materials: [],

                show: true,

                material_ids: [],

                material_units: []
            }
        },

        mounted () {
            this.getServiceMaterials()
        },

        methods: {
            getServiceMaterials () {
                return axios.get(`/api/services/${this.$route.params.service_id}/materials`)
                            .then(response => {
                                this.service_materials = response.data.service_materials

                                response.data.service_materials.forEach(item => {
                                    this.service_material_ids.push(item.id)
                                    this.service_material_prices[item.id] = item.price
                                    this.service_material_quantities[item.id] = item.quantity

                                    this.service_material_rates[item.id] = item.pivot.rate

                                })
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

            saveServiceMaterial () {
                axios.post(`/api/services/${this.$route.params.service_id}/materials/store`, {
                    'service_material_ids': this.service_material_ids,
                    'service_material_rates': this.removeEmptyElem(this.service_material_rates),
                    'service_material_quantities': this.removeEmptyElem(this.service_material_quantities),
                }).then(response => {
                    window.location.reload(true)
                }).catch(err => {
                    console.log(err)
                })
            },
        },
    }
</script>

<style scoped lang="scss">
$main-color: #00A4D1;

input:required:valid {
    border-color: #495057 !important;
}

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
  &--height {
    line-height: 37px;
  }
}

.main-caption img, .main-subtitle img {
   width: 16px;
   cursor: pointer;
 }
</style>
