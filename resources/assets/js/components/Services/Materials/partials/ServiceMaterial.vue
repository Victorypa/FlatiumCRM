<template>
    <div class="row justify-content-between align-items-center col-12 py-2">

        <div class="col-6">
          <div class="form-check">
            <input class="form-check-input"
                   :id="'service-material-' + material.id"
                   type="checkbox"
                   :checked="true"
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

            <!-- <input type="text"
                   class="form-control col-3 ml-2"
                   placeholder="Расход/м2"
                   :id="'service-material-' + material.id"
                   v-model="service_material_rates[material.id]"
                   > -->

          <!-- <div class="total-sum col-3 text-right pr-0">
              <template v-if="service_material_quantities[material.id] && service_material_rates[material.id]">
                  {{ MaterialCalculation(service_material_quantities[material.id], service_material_rates[material.id], material.price) }} Р
              </template>
              <template v-else>
                  0 Р
              </template>
          </div>

          <button @click="deleteMaterial(material.id)"
                  class="add-button add-button--remove ml-auto"
                  title="Удалить материал"
                  v-if="material.can_be_deleted"
                  >
              <img src="/img/del.svg" alt="add-button">
          </button> -->
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['material', 'rate', 'material_units'],

        created () {
            console.log(this.material);
        },

        methods: {
            updateMaterialQuantity () {
                axios.patch(`/api/materials/${this.material.id}/update`, {
                    'quantity': this.material.quantity
                })
            },

            updateMaterialUnit () {
                axios.patch(`/api/materials/${this.material.id}/update`, {
                    'material_unit_id': this.material.material_unit_id
                })
            },
        }
    }
</script>
