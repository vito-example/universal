<template>
    <div :class="customClass">
        <portal-sidebar></portal-sidebar>
        <div class="c-wrapper">
            <p-header>
                <template v-slot:breadcrumb>
                    <breadcrumb-item>
                        <inertia-link :href="route('profile.show')">
                            {{ __('Dashboard') }}
                        </inertia-link>
                    </breadcrumb-item>
                    <slot name="breadcrumb"></slot>
                </template>
            </p-header>
            <div class="c-body">
                <main class="c-main">
                    <div class="container-fluid">
                        <div class="fade-in">
                            <div class="row">
                                <slot name="main"></slot>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <p-footer></p-footer>
        </div>

        <beta-modal></beta-modal>
        <div class="back-overlay" :class="{ 'd-block': showOverlay }" @click="hideSidebar"></div>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus";
import PortalSidebar from "@/Shared/Portal/Sidebar";
import PHeader from "@/Shared/Portal/Header";
import PFooter from "@/Shared/Portal/Footer";
import BreadcrumbItem from "@/Components/BreadcrumbItem";
import BetaModal from "@/Components/Layout/Modal/BetaModal";

export default {
    components: {
        BetaModal,
        BreadcrumbItem,
        PFooter,
        PHeader,
        PortalSidebar
    },
    data () {
        return {
            showOverlay: false
        }
    },
    props: {
        customClass: String
    },
    methods: {
        hideSidebar() {
            if (window.matchMedia('(max-width: 992px)')) {
                emitter.emit('toggleMobileSidebar')
                emitter.emit('showOverlay')
            }
        }
    },
    created() {
        this.setSeoData(this.$page.props.seo)
    },
    mounted() {
        emitter.on('showOverlay', () => this.showOverlay = !this.showOverlay)
        this.showBetaModal()
    }
}
</script>

<style>
@import '../CoreUi/css/style.css';
</style>
