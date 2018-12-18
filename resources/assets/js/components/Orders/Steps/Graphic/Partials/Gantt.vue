<template>
    <div ref="gantt" style="height: 300%;"></div>
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

      mounted: function () {
          gantt.init(this.$refs.gantt)
          gantt.parse(this.$props.tasks)
      }
  }
</script>

<style>
    @import "~dhtmlx-gantt/codebase/dhtmlxgantt.css";
</style>
