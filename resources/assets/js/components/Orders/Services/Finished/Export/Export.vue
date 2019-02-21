<template>
  <div>
    <basic-header></basic-header>
    <div class="projects">
      <div class="container-fluid ">
        <div class="row">
          <navigation></navigation>

          <div class="col-md-10">

              <Detail v-if="finished_order_act.length !== 0"
                      :finished_order_act="finished_order_act"
                      />

              <RoomDetail v-if="finished_order_act.finished_rooms.length !== 0"
                          v-for="finished_room in finished_order_act.finished_rooms"
                          :finished_room="finished_room"
                          :key="'finished-room-' + finished_room.id"
                          />

          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
    import Detail from './partials/Detail'
    import RoomDetail from './partials/RoomDetail'

    export default {
        components: {
            Detail, RoomDetail
        },

        data () {
            return {
                finished_order_act: []
            }
        },

        created () {
            this.getFinishedOrderAct()
        },

        methods: {
            getFinishedOrderAct () {
                return axios.get(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/show`)
                            .then(response => {
                                this.finished_order_act = response.data
                            })
            }
        }
};
</script>
