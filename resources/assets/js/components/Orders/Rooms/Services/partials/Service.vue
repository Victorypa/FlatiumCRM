<template>
    <div class="row align-items-center">

      <label class="col-md-4 mb-0">
          <div class="form-check custom-control d-flex edit-show">
              <input class="form-check-input"
                     type="checkbox"
                     :id="'service-' + service.id"
                     @click=""
                     >

              <label class="form-check-label"
                     :for="'service-' + service.id"
                     >
                     {{ service.name }}
              </label>

              <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: service.id } }">
                      Ред.
              </router-link>
          </div>
      </label>

    <div class="col-md-8 pr-0">
      <div class="form-group form-group--margin d-flex align-items-center">
        <input type="number"
               class="form-control w-85"
               placeholder="Кол-во"
               min="0"
               v-model="quantity"
               @change=""
               >

        <div class="inputs-caption col-md-2">
            {{ service.unit.name }}
        </div>

        <input type="number"
               class="form-control w-85"
               min="0"
               disabled
               :value="service.price"
               >

        <div class="inputs-caption col-md-2">
            Р/{{ service.unit.name }}
        </div>

        <div class="form-group__calc w-85">
            <!-- {{ getServiceSummary(service.id) }} P -->
        </div>
      </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['service', 'room'],

        data () {
            return {
                quantity: 0
            }
        },

        created () {
            this.serviceQuantityAutomation()
        },

        methods: {
            serviceQuantityAutomation () {
                switch (this.service.unit_id) {
                    case 1:
                        if (this.service.service_type_id === 1) {
                            this.quantity = this.room.area
                        }
                        if (this.service.service_type_id === 2) {
                            this.quantity = this.room.wall_area
                        }

                        if (this.service.service_type_id === 3) {
                            this.quantity = this.room.area
                        }
                        break;
                    case 2:
                        this.quantity = this.room.perimeter
                        break;
                    default:
                        this.quantity = 1
                }
            }
        }

    }
</script>


<style scoped lang="scss">
.edit-show:hover {
  .edit {
    transition: 0.5s;
    opacity:1;
  }
}
.edit {
    opacity: 0;
          color: #00A4D1;
    &:hover {
      cursor: pointer;
    }
}

</style>
