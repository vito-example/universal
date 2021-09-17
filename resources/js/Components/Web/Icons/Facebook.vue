<template>
    <icon :width="width" :height="height">
      <path d="M14.5 14H17L18 10H14.5V8C14.5 6.97 14.5 6 16.5 6H18V2.64C17.674 2.597 16.443 2.5 15.143 2.5C12.428 2.5 10.5 4.157 10.5 7.2V10H7.5V14H10.5V22.5H14.5V14Z" fill="currentColor"/>
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
