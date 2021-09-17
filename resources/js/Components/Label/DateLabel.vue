<template>
    <div class="label label--light-outline flex items-center padding-x-12">
        <div class="label__icon line-height-0 padding-right-7">
            <calendar-icon
                    width="15"
                    height="16"
            />
        </div>

        {{ label }}
    </div>
</template>

<script>
import CalendarIcon from "@/Components/Web/Icons/Calendar"

export default {
    components: {
        CalendarIcon
    },

    props: {
        label: {
            type: String
        }
    }
}
</script>