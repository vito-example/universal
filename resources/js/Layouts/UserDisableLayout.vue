<template>
    <div>
        <portal-sidebar></portal-sidebar>
        <div class="c-wrapper">
            <p-header>
                <template v-slot:breadcrumb>
                    <breadcrumb-item>
                        <inertia-link :href="route('dashboard')">
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
    </div>
</template>

<script>
import PortalSidebar from "@/Shared/Portal/Sidebar";
import PHeader from "@/Shared/Portal/Header";
import PFooter from "@/Shared/Portal/Footer";
import BreadcrumbItem from "@/Components/BreadcrumbItem";
export default {
    components: {
        BreadcrumbItem,
        PFooter,
        PHeader,
        PortalSidebar
    }
}
</script>

<style>
@import '../CoreUi/css/style.css';
</style>
