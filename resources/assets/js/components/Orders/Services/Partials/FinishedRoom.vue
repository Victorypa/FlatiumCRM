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


      <template v-for="(room_services, service_type_id) in room_service_ids">
            <div class="projects__information ">
              <div class="row bg px-3">
                <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                  {{ getServiceTypeName(service_type_id) }}
                </div>

                <div class="col-12 px-0">
                    <table class="table table-hover">
                      <tbody>
                        <tr v-for="room_service in room_services">
                          <th scope="row" class="w-50 pl-1">
                            <div class="form-check custom-control checkbox">
                              <input class="form-check-input check"
                                     :id="'service-' + room_service.service_id"
                                     type="checkbox"
                                     :checked="finished_room_service_ids.includes(room_service.service_id)"
                                     @click="addToSelectedServiceId(room_service.service_id)"
                                     >
                              <label class="form-check-label d-block" :for="'service-' + room_service.service_id">
                                  {{ getServiceDetails(room_service.service_id, 'name') }}
                              </label>
                            </div>
                          </th>
                          <td class="py-1 pl-1">
                              <div class="d-flex align-items-center">
                                  <input type="number"
                                         class="form-control w-85"
                                         :id="'service-' + room_service.service_id"
                                         min="0"
                                         v-model="selected_service_quantities[room_service.service_id]"
                                         @change="linkSelectedServicesToFinishedRoom()"
                                         >
                                  <div class="col-auto pl-2">
                                      {{ getServiceDetails(room_service.service_id, 'unit') }}
                                  </div>
                              </div>
                          </td>

                          <td>
                              {{ getServiceDetails(room_service.service_id, 'price') }} Р/{{ getServiceDetails(room_service.service_id, 'unit') }}
                          </td>

                          <td>
                              {{ calculateServiceAmount(getServiceDetails(room_service.service_id, 'price'), selected_service_quantities[room_service.service_id]) }} Р
                          </td>

                        </tr>
                      </tbody>
                    </table>
                </div>
              </div>


        </div>
      </template>
    </div>
</template>

<script>
    import OrderExportCollection from '../../../../mixins/OrderExportCollection'
    export default {
        props: ['room', 'order'],

        mixins: [OrderExportCollection],

        data () {
            return {
                finished_room_service_ids: [],

                selected_service_ids: [],
                selected_service_quantities: [],

                room_service_ids: []
            }
        },

        beforeMount() {
          this.getServicesQuantities()
          // this.getSelectedServices()
        },

        mounted () {
            this.RoomServicesInit()
        },

        methods: {
            RoomServicesInit() {
                this.room_service_ids = _.groupBy(this.room.room_services, 'service_type_id')
            },


            getServicesQuantities() {
                this.room.room_services.forEach(room_service => {
                    this.selected_service_quantities[room_service.service_id] = parseFloat(room_service.quantity).toFixed(1)
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
