<template>
        <div class="col-12 px-0">

          <div class="px-15">
              <h2 class="main-subtitle main-subtitle--room">
                  {{ finished_room.room.description ? finished_room.room.description : finished_room.room.room_type.type }}
              </h2>

              <template v-if="finished_room.room.room_type_id === 1">
                    <div class="projects__desc col-8 d-flex justify-content-between align-items-center py-3 pl-0">
                        <div class="projects__desc-item">Общая площадь: {{ finished_room.room.area }} м<sup>2</sup></div>
                        <div class="projects__desc-item">Высота потолка: {{ finished_room.room.height }} м</div>
                        <div class="projects__desc-item">Площадь стен: {{ finished_room.room.wall_area }} м<sup>2</sup></div>
                        <div class="projects__desc-item">Периметр: {{ finished_room.room.perimeter }}</div>
                    </div>
                </template>
          </div>

          <template v-if="finished_room.finished_room_services">
              <template v-for="(finished_room_services, service_type_id) in groupByServiceType(finished_room.finished_room_services)">
                  <div class="projects__information ">
                      <div class="row bg px-3">

                        <div class="main-subtitle main-subtitle--fz col-12 pt-4 pl-3">
                          {{ getServiceTypeName(service_type_id) }}
                        </div>

                        <div class="col-12 px-0">

                          <table class="table table-hover">

                            <tbody>
                              <tr v-for="finished_room_service in finished_room_services">
                                <th scope="row" class="w-50">{{ finished_room_service.name }}</th>
                            <td>{{ finished_room_service.quantity }} {{ finished_room_service.service.unit.name }}</td>

                                <template v-if="finished_order.order.discount">
                                    <template v-if="finished_room_service.service.can_be_discounted">
                                        <td>{{ finished_room_service.price * (1 - parseInt(finished_order.order.discount)/100) }} Р/{{ finished_service.unit.name }}</td>
                                        <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price * (1 - parseInt(finished_order.order.discount)/100)) }} Р</td>
                                    </template>
                                    <template v-else>
                                        <td>{{ finished_service.price }} Р/{{ finished_service.unit.name }}</td>
                                        <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price) }} Р</td>
                                    </template>
                                </template>
                                <template v-if="finished_order.order.markup">
                                    <td>{{ finished_service.price * (1 + parseInt(finished_order.order.markup)/100) }} Р/{{ finished_service.unit.name }}</td>
                                    <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price * (1 + parseInt(finished_order.order.markup)/100)) }} Р</td>
                                </template>
                                <template v-if="finished_order.order.discount === null && finished_order.order.markup === null">
                                    <td>{{ finished_service.price }} Р/{{ finished_service.unit.name }}</td>
                                    <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price) }} Р</td>
                                </template>
                              </tr>

                            </tbody>
                          </table>

                        </div>
                      </div>
                  </div>
              </template>
          </template>

        </div>


</template>

<script>
    export default {
        props: ['finished_room']
    }
</script>
