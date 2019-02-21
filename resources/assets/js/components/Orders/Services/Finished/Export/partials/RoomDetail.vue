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

          <div class="projects__information"
               v-if="finished_room.finished_room_services"
               v-for="(finished_room_services, service_type) in groupByServiceType(finished_room.finished_room_services)"
               >
              <div class="row bg px-3">

                <div class="main-subtitle main-subtitle--fz col-12 pt-4 pl-3">
                    {{ service_type }}
                </div>

                <div class="col-12 px-0">

                  <table class="table table-hover">

                    <tbody>
                        <RoomServiceDetail v-for="finished_room_service in finished_room_services"
                                           :finished_room_service="finished_room_service"
                                           :finished_room="finished_room"
                                           :key="'finished-room-service-' + finished_room_service.id"
                                           />
                    </tbody>
                  </table>

                </div>
              </div>
          </div>


        </div>


</template>

<script>
    import RoomServiceDetail from './RoomServiceDetail'

    export default {
        props: ['finished_room'],

        components: {
            RoomServiceDetail
        },

        methods: {
            groupByServiceType(services) {
                return _.groupBy(services, 'service.service_type.name')
            },
        }
    }
</script>
