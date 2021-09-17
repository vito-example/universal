<template>
    <icon :width="width" :height="height">
      <path fill-rule="evenodd" clip-rule="evenodd" stroke-width="0" fill="currentColor"/>
    </icon>
</template>
<script>
import Icon from "@/Components/Web/Icons/Icon";
export default {
    components: {Icon},
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
