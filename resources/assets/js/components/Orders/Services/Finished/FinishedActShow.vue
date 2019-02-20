<template>
    <div class="projects">
        <basic-header></basic-header>
      <div class="container-fluid ">
        <div class="row">
          <navigation></navigation>

          <div class="col-md-10">

            <div class="row col-10 fixed-part shadow bg-white rounded align-items-center">
                <div class="col-md-8">
                  <h1 class="main-caption w-100" @click="show = !show">
                    {{ description ? description : 'Акт выполненных работ' }}
                  </h1>
                </div>

                <div class="col-md-2 ml-auto" v-if="order.length !== 0">
                    <router-link :to="{ name: 'order-finished-services-export-show', params: { id: order.id, finished_act_id: this.$route.params.finished_act_id } }" target="_blank">
                        <button type="button" class="primary-button w-100">Экспорт</button>
                    </router-link>
                </div>

                <!-- <div class="col-md-6 pt-3 d-flex align-items-center">
                    <h2 class="main-subtitle">Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р</h2>
                    <div class="d-flex pl-3">
                      <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(order.original_price) }} Р</span>
                      <span class="small-case">(скидка: -{{ parseInt(order.discount) }}%)</span>
                    </div>
                </div> -->

              <template v-if="order.price">
                  <template v-if="order.discount">
                      <div class="col-md-6 pt-3 d-flex align-items-center">
                          <h2 class="main-subtitle">Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р</h2>
                          <div class="d-flex pl-3">
                            <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(order.original_price) }} Р</span>
                            <span class="small-case">(скидка: -{{ parseInt(order.discount) }}%)</span>
                          </div>
                      </div>
                  </template>
                  <template v-if="order.markup">
                      <div class="col-md-6 pt-3">
                        <h2 class="main-subtitle">Итого: {{ new Intl.NumberFormat('ru-Ru').format(order.price) }} Р</h2>
                            <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(order.original_price) }} Р</span>
                            <span class="small-case">(наценка: +{{ parseInt(order.markup) }}%)</span>
                      </div>
                  </template>
                  <template v-if="order.discount === null && order.markup === null">
                      <div class="col-md-6 pt-3">
                        <h2 class="main-subtitle">Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р</h2>
                      </div>
                  </template>

              </template>
              <template v-else>
                  <div class="col-md-6 pt-3">
                    <h2 class="main-subtitle"> Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(0)) }} Р</h2>
                  </div>
              </template>



              <template v-if="price">
                  <div class="col-md-6 pt-3 d-flex justify-content-end px-0">
                    <div class="col-12 text-right">
                      <h2 class="main-subtitle px-15"> {{ new Intl.NumberFormat('ru-Ru').format(parseInt(price)) }} Р</h2>
                    </div>
                  </div>
              </template>
              <template v-else>
                  <div class="col-md-6 pt-3 d-flex justify-content-end px-0">
                    <div class="col-12 text-right">
                      <h2 class="main-subtitle px-15"> {{ new Intl.NumberFormat('ru-Ru').format(parseInt(0)) }} Р</h2>
                    </div>

                  </div>
              </template>


            </div>
            <div class="projects__content"></div>
            <!-- <template v-if="order.rooms.length !== 0" v-for="room in order.rooms">
                <finished-room :room="room" :order="order" @price="getPrice" :key="'finished-room-' + room.id"></finished-room>
            </template> -->
          </div>
        </div>
      </div>
    </div>
</template>


<script>
// import FinishedRoom from './Partials/FinishedRoom'

  export default {
      components: {
          // FinishedRoom
      },

      data () {
          return {
              order: [],
              price: 0,
          }
      },

      created () {
          this.getFinishedOrderAct()
          this.getOrder()
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
                              this.description = response.data.description
                              this.price = response.data.price
                          })
          },

          updateFinishedOrderAct () {
              axios.patch(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/update`, {
                  'description': this.description
              }).then(response => {
                  this.show = false
              })
          },

          getPrice (value) {
              this.room_price = 0
              this.room_price = parseInt(value)
              this.getFinishedOrderAct()
          },

          priceCount (quantity, price) {
           return new Intl.NumberFormat('ru-Ru').format(parseInt(quantity * price))
       },
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
