<template>
    <div class="container-fluid px-0">

        <div class="row">
            <div class="col-md-12 pt-4 pr-0">
                    <template v-if="windows.length">
                        <div class="row col-12 px-0 justify-content-between add-space-block align-items-center" v-for="(window, index) in windows" :key="window.id">

                          <div class="col-4 px-0">
                              <button class="add-space-button pl-4 active">Проем {{ index + 1 }}</button>
                          </div>

                          <div class="col-md-8 pr-0">
                            <div class="row col-12 pr-0 form-group--margin d-flex align-items-center create-spaces">

                                <div class="form-group col-md-3 pl-0">
                                    <select class="form-control"
                                            name="type"
                                            >
                                            <option name="type" :value="window.type">
                                                <template v-if="window.type === 'window'">
                                                    Окно
                                                </template>

                                                <template v-else>
                                                    Дверь
                                                </template>
                                            </option>
                                    </select>
                                </div>


                             <div class="form-group w-85 ml-2">
                                  <input type="number"
                                         min="0"
                                         class="form-control"
                                         v-model="window.length"
                                         @change="updateWindow(window)"
                                         required
                                         >
                              </div>

                              <div class="form-group w-85 ml-3">
                                  <input type="number"
                                         min="0"
                                         class="form-control"
                                         v-model="window.width"
                                         @change="updateWindow(window)"
                                         required
                                         >
                              </div>


                             <span class="ml-3">x</span>

                              <div class="form-group w-85 ml-3">
                                  <input type="number"
                                         min="0"
                                         class="form-control"
                                         v-model="window.quantity"
                                         @change="updateWindow(window)"
                                         required
                                         >
                              </div>

                              <div class="form-group col-md-2">
                                  <div class="form-group__calc ">
                                      {{ parseFloat(window.length * window.width * window.quantity).toFixed(2) }} M<sup>2</sup>
                                  </div>
                              </div>

                              <button @click="deleteWindow(window)" class="add-button add-button--remove d-flex align-items-center ml-auto">
                                  <img src="/img/del.svg" alt="add-button">
                              </button>

                            </div>
                        </div>
                        </div>
                    </template>


                    <form @submit.prevent="save()">
                        <div class="row col-12 px-0 justify-content-between add-space-block align-items-center" v-for="(window, index) in newWindows">

                          <div class="col-4 px-0">
                            <button class="add-space-button pl-4 active">Новый проем {{ index + parseInt(1) }}</button>
                          </div>

                          <div class="col-md-8 pr-0">
                            <div class="row col-12 pr-0 form-group--margin d-flex align-items-center create-spaces">

                                <div class="form-group col-md-3 pl-0">
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


                                <div class="form-group w-85 ml-2">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Ширина"
                                           v-model="window.length"
                                           required
                                           >
                                </div>

                                <div class="form-group w-85 ml-3">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Длина"
                                           v-model="window.width"
                                           required
                                          >
                                </div>

                              <span class="ml-3">x</span>

                              <div class="form-group w-85 ml-3">
                                  <input type="text"
                                         class="form-control"
                                         placeholder="Кол-во"
                                         v-model="window.quantity"
                                         required
                                         >
                              </div>

                              <div class="form-group col-md-2">
                                  <div class="form-group__calc ">
                                      {{ window.length * window.width * window.quantity }} M<sup>2</sup>
                                  </div>
                              </div>

                              <button @click="deleteNewWindow(window)" class="add-button add-button--remove d-flex align-items-center ml-auto">
                                  <img src="/img/del.svg" alt="add-button">
                              </button>

                            </div>
                          </div>
                        </div>

                    </form>

                    <div class="row col-12 pl-0">
                      <button class="add-space-button py-2" @click="addWindow">+ Добавить проем </button>
                    </div>
                    <hr>
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        props: ['room'],

        data () {
            return {
                windows: [],
                newWindows: [],
            }
        },


        mounted () {
            this.getRoomWindows()
        },

        methods: {
            getRoomWindows () {
                return axios.get(`/api/orders/${this.$route.params.id}/rooms/${this.room.id}/windows`)
                       .then(response => {
                           response.data.forEach(item => {
                               this.windows = item
                           })
                       })
            },


            save () {
                this.newWindows.forEach((item, index) => {
                    return axios.post(`/api/orders/${this.$route.params.id}/rooms/${this.room.id}/window/store`, {
                            'type': item.type,
                            'length': item.length,
                            'width': item.width,
                            'quantity': item.quantity
                        }).then(response => {
                            window.location.reload(true)
                        })
                })
            },

            addWindow () {
                this.newWindows.push({
                    type: 'window',
                    length: null,
                    width: null,
                    quantity: null
                })
            },

            deleteNewWindow (window) {
                this.newWindows.splice(window, 1)
            },

            updateWindow (currentWindow) {
                 axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.room.id}/windows/${currentWindow.id}/update`, {
                    'quantity': currentWindow.quantity,
                    'length': currentWindow.length,
                    'width': currentWindow.width
                }).then(response => {
                    this.$parent.getRoom()
                })
            },

            deleteWindow (currentWindow) {
                if (confirm('Удалить ?')) {
                    axios.delete(`/api/orders/${this.$route.params.id}/rooms/${this.room.id}/windows/${currentWindow.id}/destroy`)
                         .then(response => {
                             window.location.reload(true)
                         })
                } else {
                    window.location.reload(true)
                }

            }
        },
    }
</script>


<style scoped lang="scss">

    $main-color: #00A4D1;
    $ccc: #CCCCCC;

    input:required:valid {
        border-color: #495057 !important;
    }

    .create {
        &__features {
            display: flex;
            align-items: center;

            &__name {
           font-weight: bold;
           font-size: 20px;
           display: inline-block;
           color: $ccc;
           border: none;
           cursor: pointer;
           &:hover,
           &.active {
               color: $main-color;
               border-bottom: 3px solid $main-color;
               transition-duration: 0.3s;
           }
       }
        }
    }

    a:hover {
        text-decoration: none;
    }

    .btn-primary {
        background-color: #00A4D1;
        border-radius: .25rem;
        border: none;
        color: #fff;
        cursor: pointer;
    }

    .blank-button {
        display: none;
    }

    .w-85 {
        width:85px;
    }
</style>
