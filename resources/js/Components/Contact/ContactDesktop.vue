<template>
    <div class="contact content container margin-top-34">
        <template
                v-if="page.length"
                v-for="item in page"
        >
            <div class="flex space-between">
                <div class="contact__form width-416">
                    <h2 class="color-black font-weight-600">{{item.fields.title.value}}</h2>
                    <div
                            class="font-size-sm margin-y-24"
                            v-html="item.fields.description.value"
                    />

                    <contact-form :item="item" />
                </div>

                <div class="contact__image flex flex-column space-between">
                    <div class="flex justify-end padding-right-50">
                        <img :src="item.fields.banner_image.value" :alt="item.fields.title.value">
                    </div>

                    <contact-information
                            :item="item"
                            class="flex gap-68 padding-bottom-14"
                    />
                </div>
            </div>

            <hr class="height-2 margin-y-50">

            <div
                    class="map map--rounded"
                    v-html="item.fields.map_iframe.value"
            />
        </template>
    </div>
</template>

<script>
import ContactInformation from "./ContactInformation"
import ContactForm from "./ContactForm"

export default {
    components: {
        ContactInformation,
        ContactForm
    },

    props: {
        page: {
            type: Array
        }
    }
}
</script>