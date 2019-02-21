<template>
    <div class="projects">
        <basic-header></basic-header>
        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 mt-5">

                    <AddExtraAct @created_extra_act="getExtraActs()"/>

                    <div class="col-12 mt-5">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col"></th>
                                <th scope="col">Название</th>
                                <th scope="col">Стоимость</th>
                                <th scope="col">Начало</th>
                                <th scope="col">Окончание</th>
                              </tr>
                            </thead>
                            <tbody v-if="acts.length !== 0">
                                <ExtraAct v-for="act in acts"
                                             :act="act"
                                             :key="act.id"
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
    import AddExtraAct from './partials/AddExtraAct'
    import ExtraAct from './partials/ExtraAct'

    export default {
        components: {
            AddExtraAct, ExtraAct
        },

        data () {
            return {
                acts: []
            }
        },

        created () {
            this.getExtraActs()
        },

        methods: {
            getExtraActs () {
                axios.get(`/api/orders/${this.$route.params.id}/extra_order_acts`)
                     .then(response => {
                         this.acts = response.data
                     })
            }
        }
    }
</script>
