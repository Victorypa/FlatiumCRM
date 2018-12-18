<template>
    <div ref="gantt" style="height: 100%;"></div>
</template>

<script>
    import 'dhtmlx-gantt'
    import "dhtmlx-gantt/codebase/ext/dhtmlxgantt_tooltip.js"

    export default {
        props: {
          tasks: {
              type: Object,
              default () {
                return {
                    data: []
                }
              }
          }
      },

      mounted () {
         this.ganttInit()
      },

      methods: {
          ganttInit () {
                gantt.config.step = 1
                gantt.config.min_column_width = 50
                gantt.config.grid_width = 0
                gantt.config.row_height = 50
                gantt.config.task_height = 24

                gantt.templates.tooltip_text = function(start, end, task) {
                    return "<b>Название:</b> " + task.text +
                           "<br/><b>Начало:</b> " + moment(new Date(task.start_date)).format("DD-MM-YYYY") +
                           "<br/><b>Окончание:</b> " + moment(new Date(task.end_date)).format("DD-MM-YYYY") +
                           "<br/><b>Промежуток:</b> " + task.duration + " Дней" +
                           "<br/><b>Цена:</b> " + task.price + " Р";
                }

                gantt.templates.task_class = function(start, end, task){
                      let css = []
                      css.push("no_drag_progress")
                      return css.join(" ")
                }

                gantt.init(this.$refs.gantt)
                gantt.locale = {
                    date:{
                        month_full: [
                            "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль",
                            "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
                        ],
                        month_short: [
                            "Янв", "Фев", "Мар", "Апр", "Май", "Июн",
                            "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"
                        ],

                        day_full: [
                            "Воскресенье", "Понедельник", "Вторник",
                            "Среда", "Четверг", "Пятница","Суббота"
                        ],

                        day_short:[
                            "Вс", "Пн", "Вт",
                            "Ср", "Чт", "Пт", "Сб"
                        ]
                    }
                }
               gantt.parse(this.$props.tasks)
          },


      }
  }
</script>

<style>
    @import "~dhtmlx-gantt/codebase/dhtmlxgantt.css";

    .no_drag_progress .gantt_task_progress_drag{
        display:none !important;
    }

</style>
