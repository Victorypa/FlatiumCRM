<template>
    <div>
        <form @submit.prevent="saveNewService()">
            <div class="row px-3 pt-3 pb-1" v-for="(newService, index) in newServices">
              <div class="col-md-8">
                <input type="text"
                       placeholder="Название"
                       class="form-control"
                       v-model="newService.name"
                       >
              </div>

              <div class="col-md-2">
                <div class="d-flex align-items-center">
                      <select class="form-control col-md-6" v-model="newService.unit_id">
                          <option v-for="unit in units" :value="unit.id" >
                              {{ unit.name }}
                          </option>
                      </select>

                      <input type="number"
                             placeholder="цена за ед. измерения"
                             class="form-control col-md-6 form-group__parametres ml-3"
                             v-model="newService.price"
                             >
                </div>
              </div>

              <div class="col-2 py-2">
                  <div class="form-check custom-control checkbox">
                      <input type="checkbox"
                             class="form-check-input check"
                             :id="'service-' + index"
                             v-model="newService.can_be_discounted"
                             >
                      <label class="form-check-label d-block" :for="'service-' + index">
                          Скидка возможна
                      </label>
                  </div>
              </div>
            </div>
            <button type="submit" style="display: none;"></button>
        </form>

        <div class="row mt-2">
            <div class="add-work" @click="addService()">
              +Добавить работу
            </div>
        </div>
    </div>

</template>

<script>
    import ServiceCollection from './../mixins/ServiceCollection'

    export default {
        mixins: [ServiceCollection],

        props: ['service_type_id']
    }
</script>
