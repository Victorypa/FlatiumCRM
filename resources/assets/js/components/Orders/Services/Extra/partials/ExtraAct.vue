<template>
    <tr>
        <td></td>
        <td>
            <router-link :to="getExtraActPath">
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
            },

            getExtraActPath () {
                if (this.act.extra_rooms.length !== 0) {
                    return {
                        name: 'order-extra-services-rooms-show',
                        params: { id: this.$route.params.id, extra_act_id: this.act.id, extra_room_id: this.act.extra_rooms[0].id  }
                    }
                }
            }
        }
    }
</script>
