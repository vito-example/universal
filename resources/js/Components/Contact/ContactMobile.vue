<template>
    <div class="contact content margin-top-34">
        <template
                v-if="page.length"
                v-for="item in page"
        >
            <div class="container">
                <div class="contact__information">
                    <h4 class="color-black font-weight-600 border-bottom-1 padding-bottom-32">
                        {{ __('საკონტაქტო ინფორმაცია') }}
                    </h4>

                    <contact-information
                            :item="item"
                            class="flex flex-column gap-30 margin-top-26"
                    />
                </div>

                <h4 class="color-black font-weight-600 margin-top-64">{{ __('გვიპოვეთ რუქაზე') }}</h4>
            </div>

            <div
                    class="map margin-top-28"
                    v-html="item.fields.map_iframe.value"
            />

            <div class="container">
                <h4 class="color-black font-weight-600 margin-top-64">{{ __('მოგვწერეთ') }}</h4>

                <contact-form
                        :item="item"
                        class="padding-top-6 width-full"
                />
            </div>
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