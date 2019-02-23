<template>
    <div class="projects">
        <basic-header></basic-header>
        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 mt-5">

                    <AddFinishedAct @created_finished_act="getFinishedActs()"/>

                    <div class="col-12 mt-5">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col"></th>
                                <th scope="col">Название</th>
                                <th scope="col">Стоимость</th>
                                <th scope="col">Начало</th>
                                <th scope="col">Окончание</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody v-if="acts.length !== 0">
                                <FinishedAct v-for="act in acts"
                                             :act="act"
                                             :key="act.id"
                                             @deleted-act="getFinishedActs()"
                                             />
                            </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AddFinishedAct from './partials/AddFinishedAct'
    import FinishedAct from './partials/FinishedAct'

    export default {
        components: {
            AddFinishedAct, FinishedAct
        },

        data () {
            return {
                acts: []
            }
        },

        created () {
            this.getFinishedActs()
        },

        methods: {
            getFinishedActs () {
                axios.get(`/api/orders/${this.$route.params.id}/finished_order_acts`)
                     .then(response => {
                         this.acts = response.data
                     })
            }
        }
    }
</script>
