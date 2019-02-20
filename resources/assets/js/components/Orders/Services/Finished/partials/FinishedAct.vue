<template>
        <tr>
            <td></td>
            <td>
                <router-link :to="{ name: '', params: {} }">
                    {{ act.description ? act.description : act.name }}
                </router-link>
            </td>
            <td>{{ act.price }}</td>
            <td>{{ humanBeginAt }}</td>
            <td>{{ humanFinishAt }}</td>
        </tr>
</template>

<script>
    export default {
        props: ['act'],

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
