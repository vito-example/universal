<template>
    <div>
        <div class="color-black font-weight-600 flex items-center">
            <div class="label__icon width-28 justify-center line-height-0 margin-right-20 padding-left-2">
                <location-icon width="24" height="24"/>
            </div>

            {{item.fields.address.value}}
        </div>

        <div class="color-black font-weight-600 flex items-center">
            <div class="label__icon width-28 justify-center line-height-0 margin-right-20 padding-left-1">
                <phone-icon width="24" height="24"/>
            </div>

            {{item.fields.phone.value}}
        </div>

        <div class="color-black font-weight-600 flex items-center">
            <div class="label__icon width-28 justify-center line-height-0 margin-right-20">
                <message-icon width="24" height="24"/>
            </div>

            {{item.fields.email.value}}
        </div>
    </div>
</template>

<script>
import LocationIcon from "@/Components/Web/Icons/Location"
import PhoneIcon from "@/Components/Web/Icons/PhoneSecondary"
import MessageIcon from "@/Components/Web/Icons/Message"

export default {
    components: {
        LocationIcon,
        PhoneIcon,
        MessageIcon
    },

    props: {
        item: {
            type: Object
        }
    }
}
</script>