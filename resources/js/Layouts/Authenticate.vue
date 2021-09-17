<template>
    <Header/>
    <div :class="customClass">
        <slot name="main"></slot>
    </div>
    <login-popup v-if="!isAuth()" />
    <Footer/>
</template>

<script>
import Header from "@/Components/Layout/Header/Header"
import Footer from "@/Components/Layout/Footer/Footer"
import LoginPopup from "@/Components/Web/Popup/LoginPopup";

export default {
    components: {
        Header,
        Footer,
        LoginPopup
    },

    props: {
        customClass: String
    },
    created() {
        this.setSeoData(this.$page.props.seo)
        // document.body.classList.add('c-app')
        // document.body.classList.add('flex-row')
        // document.body.classList.add('align-items-center')
    }
}
</script>
