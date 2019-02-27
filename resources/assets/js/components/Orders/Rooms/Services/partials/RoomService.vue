<template>
    <div>
        <div class="row align-items-center">

            <input type="text"
                   class="col-md-1 w-85"
                   placeholder="Приоритет"
                   v-model="room_service.priority"
                   @change="updatePriority()"
                   >

            <label class="col-md-3 mb-0 d-flex align-items-center">
                <div class="form-check custom-control d-flex edit-show"
                     >
                    <input class="form-check-input"
                           type="checkbox"
                           :id="'room-service-' + room_service.id"
                           :checked="true"
                           @click="removeService()"
                           >

                    <label class="form-check-label"
                           :for="'room-service-' + room_service.id"
                           >
                           {{ room_service.service.name }}
                    </label>

                    <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: room_service.service_id } }">
                            Ред.
                    </router-link>
                </div>
            </label>

            <div class="col-md-8">
              <div class="form-group form-group--margin d-flex align-items-center">
                  <input type="number"
                         class="form-control col-md-1"
                         placeholder="Кол-во"
                         min="0"
                         v-model="room_service.quantity"
                         @change="updateQuantity()"
                         >

                  <div class="inputs-caption col-md-1">
                      {{ room_service.unit.name }}
                  </div>

                  <input type="number"
                         class="form-control col-md-2"
                         min="0"
                         disabled
                         :value="room_service.service.price"
                          >

                  <div class="inputs-caption col-md-2">
                      Р/{{ room_service.unit.name }}
                  </div>

                  <div class="form-group__calc col-md-2">
                      {{ servicePrice }} Р
                  </div>


                  <div class="col-md-2">
                      <input type="number"
                             v-if="checkServiceMarkup"
                             class="form-control"
                             min="0"
                             placeholder="Наценка"
                             v-model="room_service.markup"
                             @change="updateMarkup()"
                             >
                  </div>

                  <div class="col-md-auto">
                      <router-link :to="{ name: 'actual-material', params: { id: room_service.room.order_id, room_id: room_service.room_id, service_id: room_service.service_id }}">
                          <button class="add-button">
                              <img src="/img/plus-circle.svg" alt="add-button">
                          </button>
                      </router-link>
                  </div>
              </div>
            </div>

            <RoomServiceMaterial v-if="room_service.materials.length !== 0"
                                 v-for="material in room_service.materials"
                                 :material="material"
                                 :quantity="room_service.quantity"
                                 :key="'material-' + material.id"
                                 />
        </div>
        <br>
    </div>
</template>

<script>
    import { EventBus } from '@/bus'
    import RoomServiceMaterial from './RoomServiceMaterial'

    export default {
        props: ['room_service', 'room'],

        components: {
            RoomServiceMaterial
        },

        methods: {
            removeService () {
                axios.delete(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/${this.room_service.service_id}/destroy`)
                     .then(response => {
                         EventBus.$emit('updated-room-price')
                         this.$emit('removed-service')
                     })
            },


            updateQuantity () {
                axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/${this.room_service.service_id}/update`, {
                    'quantity': this.room_service.quantity,
                    'price': this.room_service.quantity * this.room_service.service.price,
                    'original_price': this.room_service.quantity * this.room_service.service.price
                }).then(response => {
                    EventBus.$emit('updated-room-price')
                })
            },

            updatePriority () {
                axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/${this.room_service.service_id}/update`, {
                    'priority': this.room_service.priority
                })
            },

            updateMarkup () {
                axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/${this.room_service.service_id}/update`, {
                    'markup': this.room_service.markup,
                    'original_price': this.room_service.quantity * this.room_service.service.price
                }).then(response => {
                    EventBus.$emit('updated-room-price')
                })
            },
        },

        computed: {
            servicePrice () {
                if (this.room_service.markup) {
                    return new Intl.NumberFormat('ru-Ru').format(parseInt(this.room_service.service.price * this.room_service.quantity) * (1 + (this.room_service.markup/100)))
                } else {
                    return new Intl.NumberFormat('ru-Ru').format(parseInt(this.room_service.service.price * this.room_service.quantity))
                }
            },

            checkServiceMarkup () {
                if (this.room.order.discount === null && this.room.order.markup === null) {
                    return true
                } else {
                    return false
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
