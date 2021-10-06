<template>
    <div>
        <Header />
        <slot name="main"></slot>
        <Footer />
    </div>
</template>

<script>
import AOS from "aos"

import Header from "@/Components/Layout/Header/Header";
import Footer from "@/Components/Layout/Footer/Footer";

export default {
    components: {
        Header,
        Footer,
    },
    computed: {
        logoUrl () {
            return '/logo/black/' + this.$page.props.locale + '/logo.png'
        }
    },
    created() {
        this.setSeoData(this.$page.props.seo)
    },
    mounted() {
        AOS.init({
            startEvent: 'load'
        })
    },
}
</script>
<style>

</style>
