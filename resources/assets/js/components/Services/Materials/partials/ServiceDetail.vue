<template>
    <div class="create__fixed-top col-10 shadow-light">
      <div class="row align-items-center ">

          <div class="col-md-10 d-flex align-items-end">
            <h2 class="main-caption col-8">
              {{ service.name }}
            </h2>
            <div class="main-subtitle ml-5">
                Цена: {{ service.price  }} Р
            </div>
          </div>

        <div class="col-md-2 text-right d-flex">
            <button type="button"
                    class="primary-button primary-button--outline col-6"
                    @click="$router.go(-1)">
              Назад
            </button>
        </div>

      </div>
    </div>
</template>

<script>
    export default {
        props: ['service']
    }
</script>
