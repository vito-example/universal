<template v-show="items">
    <div class="home__section container margin-top-90">
        <div class="flex space-between items-center">
            <h2 class="font-weight-600">{{ title }}</h2>

            <inertia-link
                    :href="allHref"
                    class="button button--link color-hunter-green text-decoration-none opacity-60 hide-md-down"
            >
                {{ allTitle }}
            </inertia-link>
        </div>

        <div class="row margin-top-46 margin-top-sm-32">
            <div
                    v-for="(item, key) in items"
                    :key="key"
                    class="col-4 col-lg-4 col-md-4 col-sm-12"
            >
                <training-item
                        :training="item"
                        :type="type"
                        class="margin-bottom-sm-50"
                />
            </div>
        </div>

        <div class="home__section-more">
            <hr class="margin-y-0" />
            <inertia-link
                    :href="allHref"
                    class="button button--link color-black text-decoration-none text-center block margin-top-32"
            >
                {{ allTitle }}
            </inertia-link>
        </div>
    </div>

</template>

<script>
import TrainingItem from "@/Components/Training/TrainingItem"

export default {
    components: {
        TrainingItem
    },
    props: {
        title: String,
        allTitle: String,
        allHref: String,
        items: Array,
        type: String
    },

}
</script>
