<template>
    <icon :width="width" :height="height">
      <path d="M15 19.4297V7.42969C15 4.60126 15 3.18705 14.1213 2.30837C13.2426 1.42969 11.8284 1.42969 9 1.42969H7C4.17157 1.42969 2.75736 1.42969 1.87868 2.30837C1 3.18705 1 4.60126 1 7.42969V19.4297L6.01544 16.5637C6.9844 16.01 7.46887 15.7332 8 15.7332C8.53113 15.7332 9.0156 16.01 9.98456 16.5637L15 19.4297Z" stroke-linecap="round" stroke-linejoin="round"/>
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
