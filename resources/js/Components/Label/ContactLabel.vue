<template>
    <div class="label label--light-outline flex items-center padding-x-12 padding-right-16">
        <div class="label__icon line-height-0 padding-right-10">
            <phone-icon
                    width="15"
                    height="16"
            />
        </div>

        {{__('საკონტაქტო ნომერი')}}: <br>{{ label }}
    </div>
</template>

<script>
import PhoneIcon from "@/Components/Web/Icons/Phone"

export default {
    components: {
        PhoneIcon
    },

    props: {
        label: {
            type: String
        }
    }
}
</script>