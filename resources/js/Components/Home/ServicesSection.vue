<template>
    <section class="services_home wrapper margin_bottom">
        <div class="main_titles">
            <div class="title_bg bold">
                {{ page.fields.background_title?.value }}
            </div>
            <div class="title bold main_blue" v-html="page.fields.title?.value">
            </div>
        </div>
        <div class="service_boxes">
            <service-item
                v-for="(item, key) in items"
                :key="key"
                :item="item"
            />
        </div>
    </section>
</template>

<script>
import ServiceItem from "@/Components/Home/Service/ServiceItem"

export default {
    components: {
        ServiceItem
    },

    props: {
        page: Array,
        items: Array
    },
}
</script>
