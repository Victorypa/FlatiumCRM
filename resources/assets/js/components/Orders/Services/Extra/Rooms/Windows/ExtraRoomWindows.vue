<template>
    <!-- <div class="row col-12 justify-content-between add-space-block align-items-center" v-for="(window, index) in extra_room.extra_windows" :key="window.id">

      <div class="col-3 px-0">
          <button class="add-space-button pl-4 active">Проем {{ index + parseInt(1) }}</button>
      </div>

        <div class="col-md-9">
            <div class="row col-12 form-group--margin d-flex align-items-center create-spaces">

            <div class="form-group col-md-3">
                <select class="form-control"
                        name="type"
                        >
                        <option name="type" :value="window.type">
                            <template v-if="window.type === 'window'">
                                Окно
                            </template>

                            <template v-else>
                                Дверь
                            </template>
                        </option>
                </select>
            </div>


          <div class="form-group col-md-2">
              <input type="number"
                     min="0"
                     class="form-control"
                     v-model="window.length"
                     @change="updateExtraWindow(window)"
                     required
                     >
          </div>

          <div class="form-group col-md-2">
              <input type="number"
                     min="0"
                     class="form-control"
                     v-model="window.width"
                     @change="updateExtraWindow(window)"
                     required
                     >
          </div>


          <span>x</span>

          <div class="form-group col-md-2">
              <input type="number"
                     min="0"
                     class="form-control"
                     v-model="window.quantity"
                     @change="updateExtraWindow(window)"
                     required
                     >
          </div>

          <div class="form-group col-md-2">
              <div class="form-group__calc form-group__parametres">
                  {{ parseFloat(window.length * window.width * window.quantity).toFixed(2) }} M<sup>2</sup>
              </div>
          </div>

          <button @click="deleteExtraWindow(window)" class="add-button add-button--remove d-flex align-items-center ml-auto">
              <img src="/img/del.svg" alt="add-button">
          </button>

        </div>
        </div>
    </div> -->

</template>

<script>
    export default {

    }
</script>
