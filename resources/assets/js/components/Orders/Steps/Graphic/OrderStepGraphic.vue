<template>
    <div>
      <basic-header></basic-header>

      <section class="work-stages">
          <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10">
                    <div class="row col-10 fixed-part align-items-center shadow bg-white rounded">
                        <div class="col-md-10">
                          <h1 class="main-caption w-100">
                            График работ
                          </h1>
                        </div>

                        <div class="col-md-2">
                            <router-link :to="{ name: 'order-step', params: { id: order.id } }" >
                                <button type="button" class="primary-button w-100">
                                    Назад
                                </button>
                            </router-link>
                        </div>
                    </div>

                    <div class="stages__pt"></div>

                    <template v-if="tasks.data.length && order">
                        <gantt :tasks="tasks" :order="order" @update-date="updateDate"></gantt>
                    </template>
                </div>
            </div>
          </div>
      </section>
    </div>
</template>

<script>
    import Gantt from './Partials/Gantt.vue';
    export default {
        data () {
            return {
                order: [],
                order_steps: [],

                tasks: {
                    data: []
                }
            }
        },

        components: {
            Gantt
        },

        mounted () {
            this.getOrder()
        },

        methods: {
            getOrder () {
                return axios.get(`/api/orders/${this.$route.params.id}/order_steps`)
                            .then(response => {
                                this.order = response.data
                                response.data.order_steps.forEach(order_step => {
                                    this.order_steps.push({
                                        id: order_step.id,
                                        color: order_step.color,
                                        text: order_step.description ? order_step.description : order_step.name,
                                        start_date: moment(new Date(order_step.begin_at)).format("DD-MM-YYYY"),
                                        end_date: moment(new Date(order_step.finish_at)).format("DD-MM-YYYY"),
                                        duration: moment(new Date(order_step.finish_at)).diff(moment(new Date(order_step.begin_at)), 'days'),
                                        price: order_step.price
                                    })
                                })
                                this.tasks.data = this.order_steps
                            })
            },

            updateDate (id, item) {
                this.updateOrderStepBeginAt(id, item.start_date)
                this.updateOrderStepFinishAt(id, item.end_date)
            },


            updateOrderStepBeginAt (order_step_id, begin_at) {
                axios.patch(`/api/orders/${this.$route.params.id}/order_step/${order_step_id}/update`, {
                    'begin_at': moment(new Date(begin_at)).format("DD-MM-YYYY")
                })
            },

            updateOrderStepFinishAt (order_step_id, finish_at) {
                axios.patch(`/api/orders/${this.$route.params.id}/order_step/${order_step_id}/update`, {
                    'finish_at': moment(new Date(finish_at)).format("DD-MM-YYYY")
                })
            }
        }
    }
</script>


<style lang="scss" scoped>
    $white: #fff;
    $main-color: #00A4D1;
    $ccc: #CCCCCC;
    $button-hover:#03B8E9;
    $text-color: #777777;
  .fixed {
    &-part {
      position: fixed;
      background-color: $white;
      padding-bottom: 35px;
      padding-top: 85px;
      z-index: 999;
    }
    &-footer {
      position: fixed;
      left: 16.7%;
      right: 0;
      bottom: 0;
      height: 60px;
      background-color: #fff;
      border-top: 1px solid $main-color;
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

  .form-control {
      border-radius: 0;
      &::placeholder {
        opacity: 0.3;
      }
      &:focus,
      &:hover {
        box-shadow: none;
        border-color: #000;
      }
    }


  .stages {
    &__pt {
      margin-top: 240px;
    }
    &__summ {
      font-size: 14px;
      color: #666;
      font-weight: 700;
      span {
        margin-left: 10px;
        font-size: 35px;
        color: #000;
      }
    }
  }

  table {
    color: $text-color;
    tr {
      cursor: pointer;
    }
    th {
      font-weight: normal;
    }
  }

  .add-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    &:focus {
      outline: none;
    }
    img {
      width: 35px;
      border-radius: 50%;
      &:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      }
    }
    &--remove {
      color: $main-color;
      img {
        width: 15px;
      }
    }
  }

  .add-space {
    &-button {
      padding-left: 25px;
      color: $main-color;
      background-color: transparent;
      border: none;
      cursor: pointer;
      transition: 1s;
      &:focus {
        outline: none;
      }
    }
  }
  .my-datepicker {
    border: none;
    border-bottom: 1px solid #ccc;
  }


  .table {
    &-subtitle {
      &__items {
      background-color: #f2f4f5;
      }
      font-weight: bold;
      color: #000;
      background-color: #f2f4f5;
      padding: 0.75rem;
    }
    &__transparent-row {
      background-color: #fff;
    }
    tr {
      background-color: #eff8ff;
    }
    th, td {
      border-top: 0;
    }
  }

  .main {
    &-subtitle {
      margin-bottom: 0;
      &--font {
        font-size: 20px;
      }
      img {
        width: 14px;
        cursor: pointer;
      }
    }
}

</style>
