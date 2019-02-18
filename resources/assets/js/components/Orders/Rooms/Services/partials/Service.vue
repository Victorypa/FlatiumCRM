<template>
    <div class="row align-items-center" v-if="show">
      <label class="col-md-3 mb-0">
          <div class="form-check custom-control d-flex edit-show">
              <input class="form-check-input"
                     type="checkbox"
                     :id="'service-' + service.id"
                     @click.prevent="addService()"
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

    <div class="col-md-9 pr-0">
      <div class="form-group form-group--margin d-flex align-items-center">
        <input type="number"
               class="form-control w-85 col-md-2"
               placeholder="Кол-во"
               min="0"
               v-model="quantity"
               @change=""
               >

        <div class="inputs-caption col-md-2">
            {{ service.unit.name }}
        </div>

        <input type="number"
               class="form-control w-85 col-md-2"
               min="0"
               disabled
               :value="service.price"
               >

        <div class="inputs-caption col-md-2">
            Р/{{ service.unit.name }}
        </div>


        <div class="form-group__calc w-85 col-md-2">
            {{ servicePrice }} P
        </div>
      </div>
    </div>
    </div>
</template>

<script>
    import { EventBus } from '@/bus'

    export default {
        props: ['service', 'room'],

        data () {
            return {
                quantity: 0,
                show: true
            }
        },

        mounted () {
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
            },

            addService () {
                this.show = !this.show

                axios.post(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/store`, {
                    'service_id': this.service.id,
                    'service_type_id': this.service.service_type_id,
                    'price': this.service.price * this.quantity,
                    'service_unit_id': this.service.unit_id,
                    'quantity': this.quantity
                }).then(response => {
                    EventBus.$emit('updated-room-price')
                    this.$emit('added-service')
                })
            }
        },

        computed: {
            servicePrice () {
                return this.quantity !== 0 ? new Intl.NumberFormat('ru-Ru').format(parseInt(this.service.price * this.quantity)) : 0
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
