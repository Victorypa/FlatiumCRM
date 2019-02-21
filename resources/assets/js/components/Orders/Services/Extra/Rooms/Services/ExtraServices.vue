<template>
    <div class="row align-items-center col-12 py-4 fixed-search">
        <div class="col-2 pb-2">
            <select class="form-control" v-model="service_type_id">
                  <option v-for="service_type in service_types" :value="service_type.id">
                      {{ service_type.name }}
                  </option>
            </select>
        </div>

        <div class="col-10 d-flex align-items-center pl-0 pb-2">
            <div class="form-group col-12 d-flex align-items-center">
                <input type="text"
                       class="form-control"
                       placeholder="Название вида работы"
                       v-model="searchQuery"
                       autofocus
                       >
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                service_type_id: 1,
                service_types: [],
                searchQuery: ''
            }
        },

        created () {
            this.getServiceTypes()
        },

        methods: {
            getServiceTypes () {
                if (localStorage.getItem('service_types')) {
                    this.service_types = JSON.parse(localStorage.getItem('service_types'))
                } else {
                    return axios.get(`/api/service_types`).then(response => {
                        this.service_types = response.data
                        localStorage.setItem('service_types', JSON.stringify(this.service_types))
                    })
                }
            }
        }
    }
</script>
