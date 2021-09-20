<template v-show="item">
    <section class="project_count flex wrapper">
        <template
            v-for="(item, key) in item.fields.fields.value"
            :key="key"
        >
            <statistic-item
                :statistic="item"
            />
        </template>
    </section>
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
