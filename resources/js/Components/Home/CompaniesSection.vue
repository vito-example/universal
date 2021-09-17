<template v-show="item">
    <div
            class="home__section home__section--companies container margin-top-52 margin-top-sm-62"
            data-aos="fade"
            data-aos-offset="100"
            data-aos-duration="1000"
    >
        <h4 class="color-dim-gray font-weight-300 text-center padding-x-sm-70">{{ title }}</h4>

        <div
                v-if="title"
                class="companies__grid grid grid-5 grid-sm-2 gap-54 space-between padding-top-40 padding-x-110 padding-x-sm-0"
        >
            <company-item
                    v-for="(item, key) in companyData"
                    :key="key"
                    :company="item"
            />
        </div>
    </div>
</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"
import CompanyItem from "@/Components/Home/Companies/CompanyItem";

export default {
    props: {
        item: Array
    },

    components: {
        LazyImage,
        CompanyItem
    },

    computed: {
        title () {
            return this.item?.fields?.title?.value
        },

        companyData () {
            return this.item?.fields?.fields?.value
        }
    }
}
</script>
