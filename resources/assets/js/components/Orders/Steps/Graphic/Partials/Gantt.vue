<template>
    <div ref="gantt" style="height: 70%;"></div>
</template>

<script>
    import 'dhtmlx-gantt'
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
                gantt.config.min_column_width = 100
                gantt.config.grid_width = 0

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
