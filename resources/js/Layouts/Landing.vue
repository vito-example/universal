<template>
    <div>
        <Header />

        <slot name="main"></slot>

        <Footer />
        <beta-modal />
        <login-popup v-if="!isAuth()" />
        <finish-profile-popup v-if="isAuth()" />
        <verify-email-popup v-if="isAuth()" />
        <verify-popup v-if="isAuth()" />
        <password-reset-popup />

    </div>
</template>

<script>
import AOS from "aos"

import Header from "@/Components/Layout/Header/Header";
import Footer from "@/Components/Layout/Footer/Footer";
import RegisterEventModal from "@/Components/Event/RegisterEventModal";
import EventInfoModal from "@/Components/Event/EventInfoModal";
import BetaModal from "@/Components/Layout/Modal/BetaModal";
import LoginPopup from "@/Components/Web/Popup/LoginPopup";
import VerifyPopup from "@/Components/Web/Popup/VerifyPopup";
import PasswordResetPopup from "@/Components/Web/Popup/PasswordResetPopup";
import FinishProfilePopup from "../Components/Web/Popup/FinishProfilePopup";
import VerifyEmailPopup from "../Components/Web/Popup/VerifyEmailPopup";

export default {
    components: {
        VerifyEmailPopup,
        FinishProfilePopup,
        BetaModal,
        Header,
        Footer,
        LoginPopup,
        VerifyPopup,
        PasswordResetPopup,
        RegisterEventModal,
        EventInfoModal,
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

        this.showBetaModal()
    }
}
</script>
<style>

</style>
