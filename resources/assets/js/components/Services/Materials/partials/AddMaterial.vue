<template>
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

                  <div class="total-sum col-3 text-right pr-0">
                      {{ MaterialCalculation(newMaterial.quantity, newMaterial.rate, newMaterial.price) }} Р
                  </div>
                </div>
              </div>
            </div>

            <div>
                <span class="add-work" @click="addMaterial()">
                    +Добавить материал
                </span>
                <span class="add-work"
                      v-if="newMaterials.length"
                      @click="newMaterials = []"
                      >
                    Чистить
                </span>
            </div>

          <button type="submit" style="display: none;"></button>
    </form>

</template>

<script>
    export default {
        data () {
            return {
                newMaterials: [],
                material_units: []
            }
        },

        created () {
            this.getMaterialUnits()
        },

        methods: {
            MaterialCalculation (quantity, rate, price) {
                if (quantity && rate && price) {
                    return parseFloat(Math.ceil(rate/quantity) * price).toFixed(2)
                } else {
                    return 0
                }
            },

            addMaterial () {
                this.newMaterials.push({
                    name: null,
                    flat_id: 1,
                    material_unit_id: 1,
                    price: null,
                    quantity: null,
                    rate: null
                })
            },

            getMaterialUnits () {
                if (localStorage.getItem('material_units')) {
                    this.material_units = JSON.parse(localStorage.getItem('material_units'))
                } else {
                    return axios.get(`/api/material_units`)
                                .then(response => {
                                    this.material_units = response.data
                                    localStorage.setItem('material_units', JSON.stringify(this.material_units))
                                })
                }

            },

            saveNewMaterial () {
                this.newMaterials.forEach((item, index) => {
                    return axios.post(`/api/materials/store`, {
                            'service_id': this.$route.params.service_id,
                            'material_unit_id': item.material_unit_id,
                            'name': item.name,
                            'price': item.price,
                            'quantity': item.quantity,
                            'rate': item.rate,
                            'service': this.service
                        }).then(response => {
                            this.newMaterials = []
                            this.$emit('added-material')
                        })
                })
            },
        }
    }
</script>
