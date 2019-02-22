<template>
    <div class="col-12 px-0">
      <div>
        <h2 class="main-subtitle main-subtitle--room pl-3">
            {{ room.description ? room.description : room.room_type.type }}
        </h2>

        <template v-if="room.room_type_id === 1">
            <div class="projects__desc col-10 d-flex justify-content-between align-items-center py-3">
              <div class="projects__desc-item">Общая площадь: {{ room.area }} м<sup>2</sup></div>
              <div class="projects__desc-item">Высота потолка: {{ room.height }} м</div>
              <div class="projects__desc-item">Площадь стен: {{ room.wall_area }} м<sup>2</sup></div>
              <div class="projects__desc-item">Периметр: {{ room.perimeter }}</div>
            </div>
        </template>
      </div>

            <div class="projects__information"
                 v-if="groupByRoomServices.length !== 0"
                 v-for="(room_services, service_type) in groupByRoomServices"
                 >
              <div class="row bg px-3">
                <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                  {{ service_type }}
                </div>

                <div class="col-12 px-0">
                    <table class="table table-hover">
                      <tbody>
                          <FinishedRoomService v-if="room.room_services.length !== 0"
                                               v-for="room_service in room.room_services"
                                               :room_service="room_service"
                                               :room="room"
                                               :key="'finished-room-service-' + room_service.id"
                                               />
                      </tbody>
                    </table>
                </div>
              </div>


        </div>

    </div>
</template>

<script>
    import FinishedRoomService from './FinishedRoomService'

    export default {
        props: ['room'],

        components: {
            FinishedRoomService
        },

        computed: {
            groupByRoomServices () {
                return _.groupBy(this.room.room_services, 'service_type.name')
            }
        },
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
