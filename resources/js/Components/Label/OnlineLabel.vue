<template>
    <div class="label label--light-outline color-apple-green flex items-center padding-x-12">
        <div class="label__icon line-height-0 padding-right-7">
            <video-icon
                    width="15"
                    height="16"
            />
        </div>

        {{ label }}
    </div>
</template>

<script>
import VideoIcon from "@/Components/Web/Icons/Video"

export default {
    components: {
        VideoIcon
    },

    props: {
        label: {
            type: String
        }
    }
}
</script>