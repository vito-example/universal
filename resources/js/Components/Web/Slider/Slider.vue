<template>
  <div class="slider">
    <div class="slider__inner">
      <div class="slider__track">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
import Slide from './Slide'

export default {
  components: {
    Slide
  },

  props: {
    items: {
      type: Array
    }
  },

  computed: {
    total () {
      return this.items?.length
    }
  }
}
</script>