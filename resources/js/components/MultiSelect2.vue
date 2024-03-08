<template>
  <select>
    <slot></slot>
  </select>
</template>

<script>
  export default {
    name: 'Select2',
    props: ['options', 'value'],
    mounted() {
      let vm = this;
      $(this.$el)
        // init select2
        .val(this.value)
        .select2({
          data: this.options,
          theme: 'bootstrap4',
        })
        .trigger('change')
        // emit event on change.
        .on('change', function() {
          vm.$emit('input', $(this).val());
        });
    },
    watch: {
      value(value) {
        // update value
        if ([...value].sort().join(',') !== [...$(this.$el).val()].sort().join(',')) {
          $(this.$el)
            .val(value)
            .trigger('change');
        }
      },
      options(options) {
        // update options
        $(this.$el)
          // .empty()
          .select2({ data: options, theme: 'bootstrap4' });
      },
    },
    destroyed() {
      $(this.$el)
        .off()
        .select2('destroy');
    },
  };
</script>

<style></style>
