<template>
    <tr>
        <td></td>
        <td>
            <router-link :to="{ name: 'order-finished-act-show', params: { id: this.$route.params.id, finished_act_id: act.id } }">
                {{ act.description ? act.description : act.name }}
            </router-link>
        </td>
        <td>{{ act.price }}</td>
        <td>{{ humanBeginAt }}</td>
        <td>{{ humanFinishAt }}</td>
        <td>
            <p class="cursor" @click="deleteFinishedAct()">
                Удалить
            </p>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['act'],

        methods: {
            deleteFinishedAct () {
                
            }
        },

        computed: {
            humanBeginAt () {
                return moment(this.act.begin_at).format('DD-MM-YYYY')
            },

            humanFinishAt () {
                return moment(this.act.finish_at).format('DD-MM-YYYY')
            }
        }
    }
</script>

<style scoped>
    .cursor {
        cursor: pointer;
    }
</style>
