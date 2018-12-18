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
          },

          order: {
              type: Object,
              required: true
          }
      },

      mounted () {
         this.ganttInit()
      },

      methods: {
          ganttInit () {
                gantt.attachEvent("onAfterTaskUpdate", (id, item) => {
                    this.$emit('update-date', id, item)
                })

                gantt.config.step = 1
                gantt.config.drag_links = false
                gantt.config.min_column_width = 50
                gantt.config.grid_width = 0
                gantt.config.row_height = 50
                gantt.config.task_height = 24

                gantt.templates.tooltip_text = function(start, end, task) {
                    return "<b>Название:</b> " + task.text +
                           "<br/><b>Начало:</b> " + moment(new Date(task.start_date)).format("DD-MM-YYYY") +
                           "<br/><b>Окончание:</b> " + moment(new Date(task.end_date)).format("DD-MM-YYYY") +
                           "<br/><b>Промежуток:</b> " + task.duration + " Дней" +
                           "<br/><b>Цена:</b> " + (task.price ? task.price : 0) + " Р";
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

    /* .gantt_task_line, .gantt_line_wrapper {
        margin-top: -9px;
    }
    .gantt_side_content {
        margin-bottom: 7px;
    }
    .gantt_task_link .gantt_link_arrow {
        margin-top: -12px
    }
    .gantt_side_content.gantt_right {
        bottom: 0;
    } */

</style>
