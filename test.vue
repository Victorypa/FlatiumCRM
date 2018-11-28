<template>
<div>

  <basicheader></basicheader>

  <div class="projects">

    <div class="container-fluid ">
      <div class="row">
        <sidebar></sidebar>

        <div class="col-md-10">

          <div class="row col-10 fixed-part shadow bg-white rounded px-0 align-items-center">
            <div class="col-md-8 pl-1">
              <h1 class="main-caption">
                Название сметы (адрес)
              </h1>
            </div>

            <div class="col-md-2">
              <button type="button" class="primary-button primary-button--outline w-100">График</button>
            </div>

            <div class="col-md-2">
              <button type="button" class="primary-button w-100">Редактировать</button>
            </div>

            <div class="col-md-12 pt-3">
              <h2 class="main-subtitle px-15"> <span>Общая S:</span> 200 м<sup>2</sup> <span>Итого:</span>
                2 120 000 Р </h2>
            </div>

          </div>

          <div class="col-12 px-0">

            <div class="projects__content px-15">

              <div class="row align-items-center pt-4">
                <div class="col-10">
                  <div class="form-group d-flex align-items-center">
                    <input type="text" class="form-control" placeholder="Имя клиента">
                    <div class="col-3">
                      <select class="form-control">
                        <option selected disabled>Имя менеджера</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                      </select>
                    </div>
                    <input type="text" class="form-control" placeholder="Телефон менеджера">
                    <input type="text" class="form-control" placeholder="№ Договора">
                  </div>
                  </div>

                  <div class="col-md-2">
                    <button type="button" class="primary-button w-100">Экспорт</button>
                  </div>
                </div>
                <div class="col-12 px-0 pt-3">
                  <div class="form-check custom-control checkbox">
                    <input class="form-check-input check" id="exportmaterials" type="checkbox">
                    <label class="form-check-label" for="exportmaterials">
                    Экспортировать с материалами
                  </label>
                  </div>
                </div>

                <h2 class="main-subtitle main-subtitle--room">
                  Комната 1
                </h2>
                <div class="projects__desc col-8 d-flex justify-content-between align-items-center pt-3">

                  <div class="projects__desc-item">Общая площадь: 28 м<sup>2</sup></div>
                  <div class="projects__desc-item">Высота потолка: 2,8 м</div>
                  <div class="projects__desc-item">Площадь стен: 80,1 м<sup>2</sup></div>
                  <div class="projects__desc-item">Периметр: 29,8</div>

                </div>
              </div>

              <div class="projects__information">

                <div class="row bg px-3">

                  <div class="main-subtitle main-subtitle--fz col-12 pt-4 pl-2">
                    Пол
                  </div>

                  <div class="col-12 px-0">

                    <table class="table table-hover">

                      <tbody>
                        <tr>
                          <th scope="row" class="w-50">Демонтаж деревянного пола (до основания)</th>
                          <td>28м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row" class="w-50">Монтаж чистовой стяжки самовыравнивающейся
                            смесью</th>
                          <td>28м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row" class="w-50">Укладка подложки</th>
                          <td>28м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row" class="w-50">Монтаж плинтуса МДФ</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>

                <div class="row bg px-3">

                  <div class="main-subtitle main-subtitle--fz col-12 pl-2">
                    Стены
                  </div>

                  <div class="col-12  px-0">

                    <table class="table table-hover">

                      <tbody>
                        <tr>
                          <th scope="row" class="w-50">Очистка стен от старых обоев</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Демонтаж дверей</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Демонтаж старой штукатурки</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Грунтовка стен (3 цикла)</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Штукатурка стены по маякам</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Шпатлёвка в 2 слоя</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Шлифовка стен</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Окраска стен в 2 слоя</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Оклейка обоями под покраску</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Наименование работы</th>
                          <td>28 м<sup>2</sup></td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>

                <div class="row bg px-3">

                  <div class="main-subtitle main-subtitle--fz col-12 pl-2">
                    Потолок
                  </div>

                  <div class="col-12  px-0">

                    <table class="table table-hover">

                      <tbody>
                        <tr>
                          <th scope="row" class="w-50">Наименование работы</th>
                          <td>28м2</td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Наименование работы</th>
                          <td>28м2</td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Наименование работы</th>
                          <td>28м2</td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Наименование работы</th>
                          <td>28м2</td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>
                        <tr>
                          <th scope="row">Наименование работы</th>
                          <td>28м2</td>
                          <td>100 Р/М<sup>2</sup></td>
                          <td>2800 Р</td>
                        </tr>

                      </tbody>
                    </table>

                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import basicheader from  './partials/BasicHeader'
import sidebar from  './partials/Sidebar'
export default {
  components: {
    basicheader,
    sidebar
  }
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/vars.scss";
.fixed-part {
  position: fixed;

  background-color: $white;

  padding-bottom: 35px;
  padding-top: 85px;

  z-index: 999;
}

.projects {
  &__content {
    padding-top: 250px;
    padding-bottom: 20px;

    .form-group {
      margin-bottom: 0;

      input {
        &:first-child {
          margin-left: 0;
        }

        margin-left: 10px;
      }
    }

    .form-control {
      color: 666;
      height: 45px;
    }

    .custom-control {
      padding-left: 1.25rem;
    }
  }

  &__desc {
    font-weight: bold;
    color: $text-color;
  }

  &__information {
    .table {
      color: $text-color;

      td {
        width: 13%;
      }

      th {
        font-weight: normal;
      }
    }
  }
}

.form-check {
  &-label {
    padding-top: 1px;
    @include transition;
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

  input[type="checkbox"]:checked+label::after,
  .abc-checkbox input[type="radio"]:checked+label::after {
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
</style>
