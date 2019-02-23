<template>
    <div class="row justify-content-between align-items-center col-12">
      <div class="col-6">
        <div class="form-check">
          <input class="form-check-input"
                 :id="'material-' + material.id"
                 type="checkbox"
                 @click="saveServiceMaterial()"
                 >

          <label class="form-check-label"
                 :for="'material-' + material.id">
              {{ material.name }}
          </label>
        </div>
    </div>

    <div class="col-2 d-flex pr-2 align-items-center justify-content-between">
        <div class="total-sum col-6">
            {{ filteredPrice }}
        </div>

        <input type="text"
               class="form-control ml-2 col-6"
               placeholder="Ед.уп"
               v-model="material.quantity"
               >
     </div>

       <div class="col-md-4 px-0">
           <div class="form-group d-flex align-items-center mb-0 justify-around">
               <select class="form-control col-4 ml-2">
                   <option>
                       {{ material.material_unit.name }}
                   </option>
               </select>

               <input type="text"
                      class="form-control col-3 ml-2"
                      placeholder="Расход/м2"
                      :id="'material-' + material.id"
                      v-model="rate"
                      >

              <div class="total-sum col-3 text-right pr-0">
                  {{ materialPrice }}
              </div>
        </div>
      </div>
    </div>

</template>

<script>
    export default {
        props: ['material'],

        data () {
            return {
                rate: 0
            }
        },

        methods: {
            saveServiceMaterial () {
                axios.post(`/api/services/${this.$route.params.service_id}/materials/store`, {
                    'material': this.material,
                })
            },

            updateServiceMaterial () {

            },

            updateMaterial () {
                
            }
        },

        computed : {
            filteredPrice () {
                return (new Intl.NumberFormat().format(parseInt(this.material.price)) + ' Р')
            },

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
