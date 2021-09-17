<template>
    <div class="label label--light-outline flex items-center padding-x-12">
        <div class="label__icon line-height-0 padding-right-7">
            <clock-icon
                    width="14"
                    height="16"
            />
        </div>

        {{ label }}
    </div>
</template>

<script>
import ClockIcon from "@/Components/Web/Icons/Clock"

export default {
    components: {
        ClockIcon
    },

    props: {
        label: {
            type: String
        }
    }
}
</script>