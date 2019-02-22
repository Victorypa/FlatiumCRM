<template>
    <div class="row justify-content-between align-items-center col-12 py-2">

      <div class="col-12"
           v-if="show"
           >
           <div class="row" v-if="!deleted">
               <div class="col-3">
                   <h5>{{ service.name }}</h5>
               </div>

               <div class="col-2">
                   <strong>{{ filterServicePrice }}</strong>
               </div>

               <div class="col-2">
                    <span v-if="service.can_be_discounted">
                        Есть скидка
                    </span>
                    <span class="red" v-else>
                        Нет скидки
                    </span>
               </div>

               <div class="col-1">
                    <button class="btn btn-sm btn-warning"
                            v-if="service.can_be_deleted"
                            @click="deleteService(service.id)"
                            >
                        Удалить
                    </button>
               </div>

               <div class="col-2">
                   <router-link class="btn btn-link btn-sm" :to="{ name: 'service-material', params: { service_id: service.id }}">
                        Добавить материалы
                   </router-link>
               </div>

               <div class="col-2">
                   <button class="btn btn-link btn-sm"
                           @click="show = !show"
                           >
                          Редактировать
                   </button>
               </div>

           </div>

      </div>
      <div v-else
           class="col-12"
           >
           <div class="row">
               <div class="col-3">
                   <div class="form-group">
                       <input type="text"
                              class="form-control"
                              v-model="service.name"
                              />
                   </div>
               </div>

               <div class="col-1">
                   <div class="form-group">
                       <select class="form-control" v-model="service.unit_id">
                           <option v-for="unit in units" :value="unit.id" >
                               {{ unit.name }}
                           </option>
                       </select>
                   </div>
               </div>

               <div class="col-2">
                   <div class="form-group">
                       <input type="text"
                              class="form-control"
                              v-model="service.price"
                              />
                   </div>
               </div>

               <div class="col-2">
                   <div class="form-check custom-control checkbox mt-2">
                       <input type="checkbox"
                              class="form-check-input check"
                              :id="'cb-' + service.id"
                              v-model="service.can_be_discounted"
                              :checked="service.can_be_discounted"
                              >
                       <label class="form-check-label d-block" :for="'cb-' + service.id">
                           Скидка возможна
                       </label>
                   </div>

               </div>

               <div class="col-2">
                   <div class="form-group">
                       <select class="form-control"
                               v-model="service.service_type_id"
                               @change="updateService()"
                               >
                           <option v-for="service_type in service_types" :value="service_type.id" >
                               {{ service_type.name }}
                           </option>
                       </select>
                   </div>
               </div>

               <div class="col-2">
                   <button class="btn btn-dark btn-md"
                           @click.prevent="updateService"
                           >
                           Сохранить
                   </button>
               </div>
           </div>
      </div>
    </div>
</template>

<script>
    import ServiceCollection from './../mixins/ServiceCollection'

    export default {
        mixins: [ServiceCollection],

        props: ['service'],

        data () {
            return {
                show: true
            }
        },

        methods: {
            updateService () {
                axios.patch(`/api/services/${this.service.id}/update`, {
                    'name': this.service.name,
                    'price': this.service.price,
                    'can_be_discounted': this.service.can_be_discounted,
                    'unit_id': this.service.unit_id,
                    'service_type_id': this.service.service_type_id
                }).then(response => {
                    this.show = !this.show
               })
           },

        },

        computed: {
            filterServicePrice () {
                return (new Intl.NumberFormat().format(parseInt(this.service.price)) + 'Р / ' + this.service.unit.name)
            }
        }
    }
</script>

<style scoped>
    .red {
        color: red;
    }
</style>
