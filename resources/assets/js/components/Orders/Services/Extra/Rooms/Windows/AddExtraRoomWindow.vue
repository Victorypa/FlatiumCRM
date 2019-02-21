<template>
    <div>
        <form @submit.prevent="saveNewWindows()">
            <div class="row col-12 justify-content-between add-space-block align-items-center" v-for="(window, index) in newExtraWindows" :key="window.id">

              <div class="col-3 px-0">
                <button class="add-space-button pl-4 active">Новый проем {{ index + parseInt(1) }}</button>
              </div>

              <div class="col-md-9">
                  <div class="row col-12 form-group--margin d-flex align-items-center create-spaces">

                    <div class="form-group col-md-3">
                        <select class="form-control"
                                name="type"
                                v-model="window.type"
                                value="window"
                                >
                            <option name="type" value="window">
                                Окно
                            </option>

                            <option name="type" value="door">
                                Дверь
                            </option>
                        </select>
                    </div>


                    <div class="form-group col-md-2">
                        <input type="text"
                               class="form-control"
                               placeholder="Ширина"
                               v-model="window.length"
                               required
                               >
                    </div>

                    <div class="form-group col-md-2">
                        <input type="text"
                               class="form-control"
                               placeholder="Длина"
                               v-model="window.width"
                               required
                              >
                    </div>

                 <span class="">x</span>

                  <div class="form-group col-md-2">
                      <input type="text"
                             class="form-control"
                             placeholder="Кол-во"
                             v-model="window.quantity"
                             required
                             >
                  </div>

                  <div class="form-group col-md-2">
                      <div class="form-group__calc ">
                          {{ parseFloat(window.length * window.width * window.quantity).toFixed(2) }} M<sup>2</sup>
                      </div>
                  </div>

                  <button @click="deleteNewExtraWindow(window)" class="add-button add-button--remove d-flex align-items-center ml-auto">
                      <img src="/img/del.svg" alt="add-button">
                  </button>
                </div>
              </div>
            </div>

        </form>

        <div class="row col-12">
            <button class="add-space-button py-2" @click="addExtraWindow">+ Добавить проем </button>
        </div>
    </div>

</template>

<script>
    export default {
        data () {
            return {
                newExtraWindows: []
            }
        },

        methods: {
            addExtraWindow () {
                this.newExtraWindows.push({
                    type: 'window',
                    length: null,
                    width: null,
                    quantity: null
                })
            },

            deleteNewExtraWindow(window) {
                this.newExtraWindows.splice(window, 1)
            },

            saveNewWindows () {
                this.newExtraWindows.forEach((item, index) => {
                    return axios.post(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_windows/store`, {
                            'type': item.type,
                            'length': item.length,
                            'width': item.width,
                            'quantity': item.quantity
                        }).then(response => {
                            this.newExtraWindows = []
                            this.$emit('window-created')
                        })
                })
            }
        }
    }
</script>
