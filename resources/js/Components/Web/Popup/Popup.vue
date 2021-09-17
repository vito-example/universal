<template>
  <div
      class="popup" :class="{'show': overlay}"
  >
    <div class="popup__inner">
      <div
          class="popup__content animate__animated animate__faster"
          :class="popupClasses"
          :style="{'width': width}"
          ref="popup"
      >
        <div class="popup__header flex items-center space-between">
          <div>
            <div class="font-size-md font-weight-600">{{ title }}</div>
            <div v-if="subtitle" class="font-size-xs font-weight-400 padding-top-10">{{ subtitle }}</div>
          </div>

          <button
              class="popup__close button button--link color-black text-decoration-none"
              @click="handleClose"
          >
            <close-icon width="14" height="14" />
          </button>
        </div>

        <slot />

      </div>
    </div>

    <div
        class="popup__overlay"
        @click="handleClose"
    ></div>
  </div>
</template>

<script>
import CloseIcon from "@/Components/Web/Icons/Close";

export default {
  components: {
    CloseIcon
  },

  props: {
    visible: {
      type: Boolean
    },

    title: {
      type: String
    },

    subtitle: {
      type: String
    },

    width: {
      type: String
    }
  },

  data () {
    return {
      animate: 'animate__zoomIn',
      overlay: true
    }
  },

  computed: {
    popupClasses () {
      return this.animate
    }
  },

  methods: {
    handleClose () {
      this.animate = 'animate__zoomOut'
      this.overlay = false

      this.$refs.popup.addEventListener('animationend', () => {
        this.$parent.visible = false
      })
    }
  }
}
</script>