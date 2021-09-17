<template v-show="item">
    <div class="home__section statistic container margin-top-128 margin-top-sm-90 margin-bottom-sm-20">
        <h2 class="font-weight-600 text-center-sm-up">{{ item.fields.title.value }}</h2>
        <div
                class="row margin-top-60 margin-top-sm-20"
                v-if="item.fields.fields.value"
        >
            <div
                    class="col-3 col-lg-3 col-md-3 col-sm-12"
                    v-for="(item, key) in item.fields.fields.value"
                    :key="key"
            >
                <statistic-item
                        :statistic="item"
                        class="padding-y-sm-40"
                />
            </div>
        </div>
    </div>
</template>

<script>
import StatisticItem from "@/Components/Home/Statistic/StatisticItem"

export default {
    components: {
        StatisticItem
    },

    props: {
        item: Array
    }
}
</script>
