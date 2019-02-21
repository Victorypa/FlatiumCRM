<template>
    <div class="projects">
        <basic-header></basic-header>
        <div class="container-fluid ">
          <div class="row">
            <navigation></navigation>

            <div class="col-md-10">
                <FinishedActDetail :order="order"
                                   :finished_order_act="finished_order_act"
                                   />

              <div class="projects__content"></div>

              <FinishedRoom v-if="order.rooms.length !== 0"
                             v-for="room in order.rooms"
                             :room="room"
                             :key="'finished-room-' + room.id"
                             />
            </div>
          </div>
        </div>
    </div>
</template>


<script>
    import { EventBus } from '@/bus'
    import FinishedActDetail from './partials/FinishedActDetail'
    import FinishedRoom from './partials/Rooms/FinishedRoom'

  export default {
      components: {
          FinishedRoom,
          FinishedActDetail
      },

      data () {
          return {
              order: [],
              finished_order_act: [],
              price: 0,
          }
      },

      created () {
          this.getOrder()
          this.getFinishedOrderAct()
      },

      mounted () {
          EventBus.$on('service-changed', () => {
              this.getFinishedOrderAct()
          })
      },


      methods: {
          getOrder () {
              return axios.get(`/api/orders/${this.$route.params.id}`)
                          .then(response => {
                              this.order = response.data
                          })
          },

          getFinishedOrderAct () {
              return axios.get(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/show`)
                          .then(response => {
                              this.finished_order_act = response.data
                          })
          }
      },
  };
</script>

<style lang="scss" scoped>
  .fixed-part {
    position: fixed;
    background-color: #fff;
    padding-bottom: 35px;
    padding-top: 85px;
    z-index: 999;
  }

</style>
