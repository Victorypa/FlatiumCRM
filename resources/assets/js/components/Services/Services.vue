<template>
      <div class="create-floor-work">
          <basic-header></basic-header>
        <div class="container-fluid px-0">
          <div class="row">
            <navigation></navigation>
            <div class="col-md-10 bg px-0">
              <div class="container-fluid px-0">
                <div class="fixed-part col-10 shadow-light">
                  <div class="row align-items-center ">

                    <div class="col-md-8">
                      <h2 class="main-caption">
                        Привязка материалов
                      </h2>
                    </div>
                  </div>
                </div>

                <div class="row create-floor-work__content col-12">
                      <div class="col-3">
                        <select class="form-control" v-model="service_type_id">
                          <option v-for="service_type in service_types" :value="service_type.id" :id="'service_type' + service_type.id">
                              {{ service_type.name }}
                          </option>
                        </select>
                      </div>

                   <div class="col-md-9 pr-0">
                       <input type="text"
                              placeholder="Название"
                              class="form-control"
                              v-model="quickSearchQuery"
                              >
                    </div>
                </div>


                <AddService :service_type_id="service_type_id"
                            @created-service="getServices()"
                            />

                <div class="row col-12 px-0 py-3">
                  <Service v-if="filteredServices.length"
                           v-for="service in filteredServices"
                           :service="service"
                           @deleted-service="getServices()"
                           :key="service.id"
                           />
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
</template>

<script>
    import Service from './partials/Service'
    import AddService from './partials/AddService'
    import ServiceCollection from './mixins/ServiceCollection'

    export default {
        mixins: [ServiceCollection],

        data () {
            return {
                service_type_id: 1,
                quickSearchQuery: ""
            }
        },

        components: {
            Service, AddService
        },

       computed: {
           filteredServices () {
               let data = this.services

               data = data.filter(row => {
                   return row.service_type_id === this.service_type_id
               })

               data = data.filter(row => {
                 return Object.keys(row).some(key => {
                   return (
                     String(row[key])
                       .toLowerCase()
                       .indexOf(this.quickSearchQuery.toLowerCase()) > -1
                   )
                 })
               })
               return data
           }
       }
    }
</script>

<style lang="scss" scoped>
.fixed-part {
  position: fixed;

  padding-top: 85px;
  padding-bottom: 35px;

  background-color: #fff;
  z-index: 999;
}
</style>
