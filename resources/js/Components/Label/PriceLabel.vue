<template>
    <div class="label label--light-outline flex items-center padding-x-12">
        <div class="label__icon line-height-0 padding-right-7">
            <cash-icon
                    width="15"
                    height="12"
            />
        </div>

        {{ label }}
    </div>
</template>

<script>
import CashIcon from "@/Components/Web/Icons/Cash"

export default {
    components: {
        CashIcon
    },

    props: {
        label: {
            type: String
        }
    }
}
</script>