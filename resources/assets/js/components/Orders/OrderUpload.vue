<template>
    <div>
      <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">
          <navigation></navigation>
          <div class="col-md-10">

            <div class="col-md-12 px-0">
                <button type="button" class="primary-button w-100 mp-10">
                    Загрузить
                </button>
              <table class="table mp-10">
                <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Название</th>
                      <th scope="col">Дата Загрузки</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>1</td>
                      <td>Название</td>
                      <td>Имя</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  </div>
</template>

<script>
    export default {

    }
</script>

<style lang="scss" scoped>
.mp-10 {
    margin-top: 100px;
}
</style>
