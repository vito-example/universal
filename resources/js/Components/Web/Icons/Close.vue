<template>
    <icon :width="width" :height="height">
      <path d="M1.5 13.5L13.5 1.5M1.5 1.5L13.5 13.5" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
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
