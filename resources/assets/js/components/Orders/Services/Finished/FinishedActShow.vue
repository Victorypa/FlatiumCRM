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
    $white: #fff;
    $text-color: #777777;
    $ccc: #CCCCCC;
    $main-color: #00A4D1;
    $button-hover:#03B8E9;

  .fixed-part {
    position: fixed;
    background-color: $white;
    padding-bottom: 35px;
    padding-top: 85px;
    z-index: 999;
  }

  .projects {
    &__desc {
      font-weight: bold;
      color: $text-color;
    }
    &__information {
      .table {
        color: $text-color;
        td {
          width: 13%;
        }
        th {
          font-weight: normal;
        }
      }
    }
  }

  .form-check {
    &-label {
      padding-top: 1px;
      cursor: pointer;
      &:before {
        border: 1px solid $ccc;
        border-radius: 0;
      }
      &::after {
        position: absolute;
        left: -18px;
        top: 5px;
        padding-left: 3px;
        font-size: 11px;
        color: $main-color;
      }
      &:hover {
        color: $button-hover;
      }
    }
    input[type="checkbox"]:checked+label::after,
    .abc-checkbox input[type="radio"]:checked+label::after {
      font-family: "FontAwesome";
      content: "\f00c";
    }
    label {
      cursor: pointer;
      display: inline;
      vertical-align: top;
      position: relative;
      padding-left: 5px;
      &::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 3px;
        left: 0px;
        margin-left: -1.25rem;
        border-radius: 0;
        background-color: #fff;
        transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
      }
    }
  }

  .small-case {
    font-size: 0.8rem;
    th {
      &:first-child {
        padding-left: 60px;
      }
    }
  }

  tr:hover {
    cursor: pointer;
  }

  .main-caption img {
      width: 16px;
      cursor: pointer;
    }

</style>
