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


                <div class="row col-12 px-0 py-3">
                  <div class="add-work" @click="addService()">
                    +Добавить работу
                  </div>


                  <div class="row justify-content-between align-items-center col-12 py-2" v-for="service in filteredServices" :key="service.id">
                    <div class="col-8">
                      <div class="form-check material-name">
                          {{ service.name }}
                      </div>

                    </div>

                    <template v-if="service.can_be_deleted">
                        <div class="col-4 d-flex justify-content-end align-items-center">
                          <div class="total-sum col-3">
                              {{ new Intl.NumberFormat().format(parseInt(service.price)) }} Р
                          </div>

                          <button class="add-button add-button--remove d-flex align-items-center ml-3"
                                  title="Удалить"
                                  @click.prevent="deleteService(service.id)">
                            <img src="/img/del.svg" alt="add-button">
                            <div class="remove-materials ml-1">
                              Удалить
                            </div>
                          </button>

                          <router-link :to="{ name: 'service-material', params: { service_id: service.id }}">
                              <button class="add-button ml-3" title="Добавить вид работы">
                                <img src="/img/plus-circle.svg" alt="add-button">
                              </button>
                          </router-link>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                          <div class="total-sum col-4">
                              {{ new Intl.NumberFormat('ru-Ru').format(service.price) }} Р
                          </div>

                         <div class="col-3">
                             &nbsp;
                         </div>

                         <router-link :to="{ name: 'service-material', params: { service_id: service.id }}">
                             <button class="add-button ml-3" title="Добавить вид работы">
                                  <img src="/img/plus-circle.svg" alt="add-button">
                             </button>
                         </router-link>
                        </div>
                    </template>


                    <template v-if="service.materials.length">
                        <div class="row col-12">
                          <div class="col-8 pl-5 mb-3" v-for="material in service.materials">
                            <div class="subtitle-list">
                              <div class="subtitle-list__item">{{ material.name }}</div>
                            </div>
                          </div>
                        </div>
                    </template>
                    <template v-else>
                        &nbsp;
                    </template>

                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
</template>

<script>
    import ServiceCollection from '../../mixins/ServiceCollection'

    export default {
        mixins: [ServiceCollection],

        data () {
            return {
                service_type_id: 1,
                quickSearchQuery: ""
            }
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
$white: #fff;
$main-color: #00A4D1;
$ccc: #CCCCCC;
$button-hover:#03B8E9;

a {
    color: #212529;
}

.sidebar {
  min-height: 100vh;
}

.fixed-part {
  position: fixed;

  padding-top: 85px;
  padding-bottom: 35px;

  background-color: $white;
  z-index: 999;
}

.create-floor-work {
  &__content {
    padding-top: 200px;
  }

  .form-check-label {
    &:hover {
      color: $main-color;
    }
  }

  .form-check-label,
  .total-sum {
    color: #666;
  }

  label {
    margin-bottom: 0;
  }
}

.fa-search {
  color: $main-color;

  &::before {
    position: absolute;
    top: 10px;
    right: 15px;
    z-index: 2;
  }
}

.form-check {
  &-label {
    cursor: pointer;

    &:before {
      border: 1px solid $ccc;
      border-radius: 0;
    }

    &::after {
      position: absolute;
      left: -18px;
      top: 2px;
      padding-left: 3px;
      font-size: 11px;
      color: $main-color;
    }

    &:hover {
      color: $button-hover;
    }
  }

  input[type="checkbox"]:checked + label::after {
    font-family: "FontAwesome";
    content: "\f00c";
  }

  label {
    cursor: pointer;
    display: inline;
    vertical-align: top;
    position: relative;
    padding-left: 5px;

    &::before {
      content: "";
      position: absolute;
      width: 20px;
      height: 20px;
      top: 0px;
      left: 0px;

      margin-left: -1.25rem;
      border-radius: 0;
      background-color: #fff;
      transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
    }
  }
}

.form-check {
  &--pt {
    label {
      &::before {
        top: 4px;
      }
    }
  }

  &-label {
    &--pt::after {
      top: 5px;
    }
  }
}

.add-button {
  background-color: transparent;
  border: none;
  cursor: pointer;

  &:focus {
    outline: none;
  }

  img {
    width: 35px;
    border-radius: 50%;

    &:hover {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
  }

  &--remove {
    color: #ccc;

    &:hover {
      color: $main-color;
    }

    img {
      width: 15px;
    }
  }
}

.remove-materials {
  font-size: 14px;
}

.subtitle-list {
  &__item {
    font-size: 0.85rem;
  }
}

.bt {
  border-top: 1px solid #ccc;
  padding-top: 25px;
  margin-top: 25px;
}

.form-control {
    border-radius: 0;
    &::placeholder {
        opacity: 0.3;
    }
    &:focus,
    &:hover {
        box-shadow: none;
        border-color: #000;
    }
}

.form-group {
    .form-control {
        border-radius: 0;
        font-size: 0.875rem;
        &:focus {
            border-color: #000;
            box-shadow: none;
        }
    }
}
</style>
