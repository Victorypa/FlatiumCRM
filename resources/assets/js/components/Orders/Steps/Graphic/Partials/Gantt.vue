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
                    },
                    labels:{
                        new_task:"New task",
                        icon_save:"Save",
                        icon_cancel:"Cancel",
                        icon_details:"Details",
                        icon_edit:"Edit",
                        icon_delete:"Delete",
                        confirm_closing:"",//Your changes will be lost, are you sure ?
                        confirm_deleting:"Task will be deleted permanently, are you sure?",

                        section_description:"Description",
                        section_time:"Time period",

                        /* link confirmation */

                        confirm_link_deleting:"Dependency will be deleted permanently, are you sure?",
                        link_from: "From",
                        link_to: "To",
                        link_start: "Start",
                        link_end: "End",

                        minutes: "Minutes",
                        hours: "Hours",
                        days: "Days",
                        weeks: "Week",
                        months: "Months",
                        years: "Years"
                    }
                };
               gantt.parse(this.$props.tasks)
          },


      }
  }
</script>

<style>
    @import "~dhtmlx-gantt/codebase/dhtmlxgantt.css";

    .gantt_grid {
        display: none !important;
    }
</style>
