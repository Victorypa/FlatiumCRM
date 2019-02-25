<template>
    <tr>
        <th></th>
        <th>
            <a href="#" target="_blank">
                {{ upload.path }}
            </a>
        </th>
        <th>{{ filteredDate }}</th>
        <th></th>
        <th></th>
    </tr>
</template>

<script>
    export default {
        props: ['upload'],

        computed: {
            filteredDate () {
                return moment(this.upload.created_at).format('DD-MM-YYYY')
            }
        }
    }
</script>
