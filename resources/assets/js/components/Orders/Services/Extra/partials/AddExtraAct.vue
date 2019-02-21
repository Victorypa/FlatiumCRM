<template>
    <div class="col-12">
        <div class="col-2 mt-5" v-if="show">
            <div class="form-group">
                <button type="button"
                        class="btn primary-button"
                        @click.prevent="show = !show">
                    Создать
                </button>
            </div>
        </div>

        <div class="col-12 mt-5" v-else>
            <div class="row align-items-center">
                <input type="text"
                       class="col-md-3"
                       placeholder="Название"
                       v-model="state.description"
                       >

                <datepicker class="col-md-2"
                            placeholder="Начало"
                            :language="ru"
                            v-model="state.begin_at"
                            />

                <datepicker class="my-datepicker col-md-2"
                            placeholder="Окончание"
                            :language="ru"
                            v-model="state.finish_at"
                            />

                <div class="col-md-2 ml-3">
                    <button type="submit"
                            class="btn primary-button"
                            @click.prevent="create()"
                            >
                            Создать
                    </button>
                </div>

                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-warning"
                            @click.prevent="show = !show"
                            >
                            Отменить
                    </button>
                </div>

            </div>
        </div>
    </div>


</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import { ru } from 'vuejs-datepicker/dist/locale'

    export default {
        components: {
            Datepicker
        },

        data () {
            return {
                ru,
                show: true,

                state: {
                    name: 'Акт дополнительных работ'
                }
            }
        },

        methods: {
            create () {
                axios.post(`/api/orders/${this.$route.params.id}/extra_order_act/store`, {
                    'state': this.state
                }).then(response => {
                    this.state = {
                        name: 'Акт выполненных работ'
                    }
                    this.show = !this.show
                    this.$emit('created_extra_act')
                })
            }
        }
    }
</script>
