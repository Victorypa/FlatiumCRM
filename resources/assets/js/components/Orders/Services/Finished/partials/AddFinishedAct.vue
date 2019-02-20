<template>
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
        <form class="row align-items-center">
            <input type="text"
                   class="col-md-3"
                   placeholder="Название"
                   >

            <datepicker class="col-md-2"
                        placeholder="Начало"
                        :language="ru"
                        v-model="data.begin_at"
                        @selected="updateFinishedOrderAct()"
                        />

            <datepicker class="my-datepicker col-md-2"
                        placeholder="Окончание"
                        :language="ru"
                        v-model="data.finish_at"
                        @selected="updateFinishedOrderAct()"
                        />

            <div class="col-md-2 ml-3">
                <button type="submit" class="btn primary-button">Создать</button>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-warning"
                        @click.prevent="show = !show"
                        >
                        Отменить
                </button>
            </div>

        </form>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import { ru } from 'vuejs-datepicker/dist/locale'

    export default {
        data () {
            return {
                show: true,

                data: {
                    name: 'Акт выполненных работ',
                    description: '',
                    begin_at: '',
                    finish_at: ''
                },

                ru
            }
        },

        components: {
            Datepicker
        },
    }
</script>
