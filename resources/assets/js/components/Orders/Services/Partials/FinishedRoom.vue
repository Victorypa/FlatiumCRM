<template>
    <div class="col-12 px-0">
      <div>
        <h2 class="main-subtitle main-subtitle--room pl-3">
            <template v-if="room.description">
                {{ room.description }}
            </template>
            <template v-else>
                {{ room.room_type.type }}
            </template>
        </h2>
        <div class="projects__desc col-10 d-flex justify-content-between align-items-center py-3">

          <div class="projects__desc-item">Общая площадь: {{ room.area }} м<sup>2</sup></div>
          <div class="projects__desc-item">Высота потолка: {{ room.height }} м</div>
          <div class="projects__desc-item">Площадь стен: {{ room.wall_area }} м<sup>2</sup></div>
          <div class="projects__desc-item">Периметр: {{ room.perimeter }}</div>

        </div>
      </div>

      <template v-if="room.services.length">
          <div class="projects__information ">

              <template v-if="room.room_type_id === 1">
                  <div class="row bg px-3">
                    <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                      Пол
                    </div>

                    <div class="col-12 px-0">
                        <table class="table table-hover">
                          <tbody>
                            <tr v-for="service in getServices(1)">
                              <th scope="row" class="w-50 pl-1">
                                <div class="form-check custom-control checkbox">
                                  <input class="form-check-input check"
                                         :id="'room-' + room.id + 'service-' + service.id"
                                         type="checkbox"
                                         :checked="finished_room_service_ids.includes(service.id)"
                                         @click="addToSelectedServiceId(service.id)"
                                         >
                                  <label class="form-check-label d-block" :for="'room-' + room.id + 'service-' + service.id">
                                      {{ service.name }}
                                  </label>
                                </div>
                              </th>
                              <td class="py-1 pl-1">
                                  <div class="d-flex align-items-center">
                                      <input type="number"
                                             class="form-control w-85"
                                             :id="'room-' + room.id + 'service-' + service.id"
                                             min="0"
                                             v-model="selected_service_quantities[service.id]"
                                             @change="linkSelectedServicesToFinishedRoom()"
                                             >
                                      <div class="col-auto pl-2">
                                          {{ service.unit.name }}
                                      </div>
                                  </div>
                              </td>

                              <template v-if="order.discount">
                                  <template v-if="service.can_be_discounted">
                                      <td>
                                          {{ service.price * (1 - parseInt(order.discount)/100) }} Р/{{ service.unit.name }}
                                      </td>
                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 - parseInt(order.discount)/100) }} Р
                                      </td>
                                  </template>
                                  <template v-if="!service.can_be_discounted">
                                      <td>
                                          {{ service.price }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                      </td>
                                  </template>
                              </template>

                              <template v-if="order.markup">
                                  <td>
                                      {{ service.price * (1 + parseInt(order.markup)/100) }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 + parseInt(order.markup)/100) }} Р
                                  </td>
                              </template>

                              <template v-if="order.markup === null && order.discount === null">
                                  <td>
                                      {{ service.price }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                  </td>
                              </template>

                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>

                  <div class="row bg px-3">
                    <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                      Стены
                    </div>

                    <div class="col-12 px-0">
                        <table class="table table-hover">
                          <tbody>
                            <tr v-for="service in getServices(2)">
                              <th scope="row" class="w-50 pl-1">
                                <div class="form-check custom-control checkbox">
                                  <input class="form-check-input check"
                                         :id="'room-' + room.id + 'service-' + service.id"
                                         type="checkbox"
                                         :checked="finished_room_service_ids.includes(service.id)"
                                         @click="addToSelectedServiceId(service.id)"
                                         >
                                  <label class="form-check-label d-block" :for="'room-' + room.id + 'service-' + service.id">
                                      {{ service.name }}
                                  </label>
                                </div>
                              </th>
                              <td class="py-1 pl-1">
                                  <div class="d-flex align-items-center">
                                      <input type="number"
                                             class="form-control w-85"
                                             :id="'room-' + room.id + 'service-' + service.id"
                                             v-model="selected_service_quantities[service.id]"
                                             @change="linkSelectedServicesToFinishedRoom()"
                                             >
                                      <div class="col-auto pl-2">
                                          {{ service.unit.name }}
                                      </div>
                                  </div>
                              </td>
                              <template v-if="order.discount">
                                  <template v-if="service.can_be_discounted">
                                      <td>
                                          {{ service.price * (1 - parseInt(order.discount)/100) }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 - parseInt(order.discount)/100) }} Р
                                      </td>
                                  </template>
                                  <template v-if="!service.can_be_discounted">
                                      <td>
                                          {{ service.price }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                      </td>
                                  </template>
                              </template>

                              <template v-if="order.markup">
                                  <td>
                                      {{ service.price * (1 + parseInt(order.markup)/100) }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 + parseInt(order.markup)/100) }} Р
                                  </td>
                              </template>

                              <template v-if="order.markup === null && order.discount === null">
                                  <td>
                                      {{ service.price }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                  </td>
                              </template>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>

                  <div class="row bg px-3">
                    <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                      Потолок
                    </div>

                    <div class="col-12 px-0">
                        <table class="table table-hover">
                          <tbody>
                            <tr v-for="service in getServices(3)">
                              <th scope="row" class="w-50 pl-1">
                                <div class="form-check custom-control checkbox">
                                  <input class="form-check-input check"
                                         :id="'room-' + room.id + 'service-' + service.id"
                                         type="checkbox"
                                         :checked="finished_room_service_ids.includes(service.id)"
                                         @click="addToSelectedServiceId(service.id)"
                                         >
                                  <label class="form-check-label d-block" :for="'room-' + room.id + 'service-' + service.id">
                                      {{ service.name }}
                                  </label>
                                </div>
                              </th>
                              <td class="py-1 pl-1">
                                  <div class="d-flex align-items-center">
                                      <input type="number"
                                             class="form-control w-85"
                                             :id="'room-' + room.id + 'service-' + service.id"
                                             v-model="selected_service_quantities[service.id]"
                                             @change="linkSelectedServicesToFinishedRoom()"
                                             >
                                      <div class="col-auto pl-2">
                                          {{ service.unit.name }}
                                      </div>
                                  </div>
                              </td>
                              <template v-if="order.discount">
                                  <template v-if="service.can_be_discounted">
                                      <td>
                                          {{ service.price * (1 - parseInt(order.discount)/100) }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 - parseInt(order.discount)/100) }} Р
                                      </td>
                                  </template>
                                  <template v-if="!service.can_be_discounted">
                                      <td>
                                          {{ service.price }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                      </td>
                                  </template>
                              </template>

                              <template v-if="order.markup">
                                  <td>
                                      {{ service.price * (1 + parseInt(order.markup)/100) }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 + parseInt(order.markup)/100) }} Р
                                  </td>
                              </template>

                              <template v-if="order.markup === null && order.discount === null">
                                  <td>
                                      {{ service.price }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                  </td>
                              </template>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </template>

              <template v-if="room.room_type_id === 2">
                  <div class="row bg px-3">
                    <div class="main-subtitle main-subtitle--fz col-12 pt-4 pl-2">
                      Электричество
                    </div>

                    <div class="col-12 px-0">
                        <table class="table table-hover">
                          <tbody>
                            <tr v-for="service in getServices(5)">
                              <th scope="row" class="w-50 pl-1">
                                <div class="form-check custom-control checkbox">
                                  <input class="form-check-input check"
                                         :id="'room-' + room.id + 'service-' + service.id"
                                         type="checkbox"
                                         :checked="finished_room_service_ids.includes(service.id)"
                                         @click="addToSelectedServiceId(service.id)"
                                         >
                                  <label class="form-check-label d-block" :for="'room-' + room.id + 'service-' + service.id">
                                      {{ service.name }}
                                  </label>
                                </div>
                              </th>
                              <td class="py-1 pl-1">
                                  <div class="d-flex align-items-center">
                                      <input type="number"
                                             class="form-control w-85"
                                             :id="'room-' + room.id + 'service-' + service.id"
                                             v-model="selected_service_quantities[service.id]"
                                             @change="linkSelectedServicesToFinishedRoom()"
                                             >
                                      <div class="col-auto pl-2">
                                          {{ service.unit.name }}
                                      </div>
                                  </div>
                              </td>
                              <template v-if="order.discount">
                                  <template v-if="service.can_be_discounted">
                                      <td>
                                          {{ service.price * (1 - parseInt(order.discount)/100) }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 - parseInt(order.discount)/100) }} Р
                                      </td>
                                  </template>
                                  <template v-if="!service.can_be_discounted">
                                      <td>
                                          {{ service.price }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                      </td>
                                  </template>
                              </template>

                              <template v-if="order.markup">
                                  <td>
                                      {{ service.price * (1 + parseInt(order.markup)/100) }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 + parseInt(order.markup)/100) }} Р
                                  </td>
                              </template>

                              <template v-if="order.markup === null && order.discount === null">
                                  <td>
                                      {{ service.price }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                  </td>
                              </template>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </template>

              <template v-if="room.room_type_id === 3">
                  <div class="row bg px-3">
                    <div class="main-subtitle main-subtitle--fz col-12 pt-4 pl-2">
                      Сантехники
                    </div>

                    <div class="col-12 px-0">
                        <table class="table table-hover">
                          <tbody>
                            <tr v-for="service in getServices(4)">
                              <th scope="row" class="w-50 pl-1">
                                <div class="form-check custom-control checkbox">
                                  <input class="form-check-input check"
                                         :id="'room-' + room.id + 'service-' + service.id"
                                         type="checkbox"
                                         :checked="finished_room_service_ids.includes(service.id)"
                                         @click="addToSelectedServiceId(service.id)"
                                         >
                                  <label class="form-check-label d-block" :for="'room-' + room.id + 'service-' + service.id">
                                      {{ service.name }}
                                  </label>
                                </div>
                              </th>
                              <td class="py-1 pl-1">
                                  <div class="d-flex align-items-center">
                                      <input type="number"
                                             class="form-control w-85"
                                             :id="'room-' + room.id + 'service-' + service.id"
                                             v-model="selected_service_quantities[service.id]"
                                             @change="linkSelectedServicesToFinishedRoom()"
                                             >
                                      <div class="col-auto pl-2">
                                          {{ service.unit.name }}
                                      </div>
                                  </div>
                              </td>
                              <template v-if="order.discount">
                                  <template v-if="service.can_be_discounted">
                                      <td>
                                          {{ service.price * (1 - parseInt(order.discount)/100) }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 - parseInt(order.discount)/100) }} Р
                                      </td>
                                  </template>
                                  <template v-if="!service.can_be_discounted">
                                      <td>
                                          {{ service.price }} Р/{{ service.unit.name }}
                                      </td>

                                      <td>
                                          {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                      </td>
                                  </template>
                              </template>

                              <template v-if="order.markup">
                                  <td>
                                      {{ service.price * (1 + parseInt(order.markup)/100) }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) * (1 + parseInt(order.markup)/100) }} Р
                                  </td>
                              </template>

                              <template v-if="order.markup === null && order.discount === null">
                                  <td>
                                      {{ service.price }} Р/{{ service.unit.name }}
                                  </td>

                                  <td>
                                      {{ calculateServiceAmount(service.price, service.pivot.quantity) }} Р
                                  </td>
                              </template>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </template>
          </div>
      </template>
    </div>
</template>

<script>
    export default {
        props: ['room', 'order'],

        data () {
            return {
                finished_room_service_ids: [],

                selected_service_ids: [],
                selected_service_quantities: []
            }
        },

        beforeMount() {
          this.getServicesQuantities()
          this.getSelectedServices()
        },

        methods: {
            getServices (service_type_id) {
                return this.room.services.filter(row => {
                    return row.service_type_id === service_type_id
                })
            },

            getServicesQuantities() {
                this.room.services.forEach(item => {
                    this.selected_service_quantities[item.id] = parseFloat(item.pivot.quantity).toFixed(1)
                })
            },

            getSelectedServices () {
                axios.get(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/finished_room/${this.filterFinishedRoomId()}/services`)
                     .then(response => {
                         response.data.selected_services.forEach(item => {
                             this.finished_room_service_ids.push(item.id)
                             this.selected_service_ids.push(item.id)
                             this.selected_service_quantities[item.id] = item.pivot.quantity
                         })
                     })
            },

            filterFinishedRoomId () {
                return this.room.finished_room.filter(row => {
                    return row.finished_order_act_id == this.$route.params.finished_act_id
                })[0].id
            },

            addToSelectedServiceId (id) {
                if (!this.finished_room_service_ids.includes(id)) {
                  this.finished_room_service_ids.push(id)
                } else {
                  var index2 = this.finished_room_service_ids.indexOf(id)

                  if (index2 > -1) {
                      this.finished_room_service_ids.splice(index2, 1);
                  }
                }
                this.linkSelectedServicesToFinishedRoom()
            },

            linkSelectedServicesToFinishedRoom () {
                axios.post(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/services/store`, {
                    'finished_room_id': this.filterFinishedRoomId(),
                    'selected_service_ids': this.finished_room_service_ids,
                    'selected_service_quantities': this.removeEmptyElem(this.selected_service_quantities)
                }).then(response => {
                    this.$emit('price', parseFloat(response.data).toFixed(2))
                })
            },

            calculateServiceAmount(price, quantity) {
                return parseFloat(price * quantity).toFixed(2)
            },

            removeEmptyElem(obj) {
                let newObj = {}

                Object.keys(obj).forEach((prop) => {
                  if (obj[prop]) { newObj[prop] = obj[prop] }
                })

                return newObj
           },
        }
    }
</script>
<style lang="scss" scoped>
.w-85 {
    width: 85px;
}
.main-subtitle--room {
  padding-top: 75px;
}
</style>
