<template>
    <svg xmlns="http://www.w3.org/2000/svg" class="inline" :width="width" :height="height" fill="none" stroke="currentColor">
        <slot />
    </svg>
</template>

<script>
export default {
    props: {
      width: {
        type: Number
      },

      height: {
        type: Number
      }
    }
}
</script>
