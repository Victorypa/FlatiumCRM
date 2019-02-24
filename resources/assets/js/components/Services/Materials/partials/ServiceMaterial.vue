<template>
    <div class="row justify-content-between align-items-center col-12 py-2">

        <div class="col-6">
          <div class="form-check">
            <input class="form-check-input"
                   :id="'service-material-' + material.id"
                   type="checkbox"
                   :checked="true"
                   @click="removeServiceMaterial()"
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
                   v-model="material.quantity"
                   @change="updateMaterialQuantity()"
                   >
        </div>

     <div class="col-md-4 px-0">
         <div class="form-group d-flex align-items-center mb-0 justify-around">

             <select class="form-control col-4 ml-2"
                     v-model="material.material_unit_id"
                     @change="updateMaterialUnit()"
                     >
                     <option v-for="material_unit in material_units"
                            :value="material_unit.id"
                            :selected="material_unit.id === material.material_unit_id"
                             >
                         {{ material_unit.name }}
                     </option>
             </select>

            <input type="text"
                   class="form-control col-3 ml-2"
                   placeholder="Расход/м2"
                   :id="'service-material-' + material.id"
                   v-model="rate"
                   >

          <div class="total-sum col-3 text-right pr-0">
              {{ materialPrice }} Р
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['material', 'material_units'],

        data () {
            return {
                rate: this.material.services.filter(row => {
                    return row.pivot.material_id === this.material.id
                })[0].pivot.rate
            }
        },

        methods: {
            removeServiceMaterial () {
                axios.post(`/api/services/${this.$route.params.service_id}/materials/remove`, {
                    'material_id': this.material.id,
                }).then(response => {
                    this.$emit('removed-service-material')
                })
            },

            updateMaterialQuantity () {
                axios.patch(`/api/materials/${this.material.id}/update`, {
                    'quantity': this.material.quantity
                })
            },

            updateMaterialUnit () {
                axios.patch(`/api/materials/${this.material.id}/update`, {
                    'material_unit_id': this.material.material_unit_id
                })
            }
        },

        computed: {
            materialPrice () {
                if (this.rate && this.material.quantity) {
                    return parseFloat(
                        Math.ceil(this.rate / this.material.quantity) * this.material.price
                    ).toFixed(2)
                }
            }
        }
    }
</script>
