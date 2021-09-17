<template>
    <div class="label label--light-outline flex items-center padding-x-12 padding-right-16">
        <div class="label__icon line-height-0 padding-right-10">
            <place-icon
                    width="15"
                    height="16"
            />
        </div>

        {{__('ჩატარების ადგილი')}}: <br>{{ label }}
    </div>
</template>

<script>
import PlaceIcon from "@/Components/Web/Icons/Place"

export default {
    components: {
        PlaceIcon
    },

    props: {
        label: {
            type: String
        }
    }
}
</script>