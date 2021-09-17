<template>
    <icon :width="width" :height="height" viewBox="0 0 24 24" fill="none" stroke="#000000"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
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
