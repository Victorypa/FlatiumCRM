<template>
    <div class="row justify-content-between align-items-center col-12 py-2">

      <div class="col-12"
           v-if="show"
           >
           <div class="row">
               <div class="col-3">
                   <h5>
                       {{ service.name }}
                   </h5>
               </div>

               <div class="col-2">
                   <strong>
                       {{ filterServicePrice }}
                   </strong>
               </div>

               <div class="col-2">
                    <span v-if="service.can_be_discounted">
                        Есть скидка
                    </span>
                    <span v-else>
                        Нет скидки
                    </span>
               </div>

               <div class="col-1">
                    <button class="btn btn-sm btn-warning"
                            v-if="service.can_be_deleted"
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
               <div class="col-4">
                   type
               </div>
               <div class="col-4">
                   name
               </div>
               <div class="col-4">
                   unit
               </div>
               <div class="col-4">
                   price
               </div>
           </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['service'],

        data () {
            return {
                show: true
            }
        },

        computed: {
            filterServicePrice () {
                return (new Intl.NumberFormat().format(parseInt(this.service.price)) + 'Р / ' + this.service.unit.name)
            }
        }
    }
</script>
