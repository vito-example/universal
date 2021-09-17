<template>
    <div class="min-h-screen bg-gray-100">
        <template v-if="showHeader">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('dashboard')">
                                    <application-logo class="block h-9 w-auto"/>
                                </inertia-link>
                            </div>
                        </div>

                        <div class="hidden ml-auto sm:flex sm:items-center text-gray-800">
                            <inertia-link :href="route('login')">
                                Log In
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div
                    class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center"
                    style="min-height: 5.625rem"
                >
                    <slot name="header"/>
                </div>
            </header>
        </template>
        <main>
            <slot></slot>
        </main>

        <!-- Modal Portal -->
    </div>
</template>

<script>
import ApplicationLogo from '@/Jetstream/ApplicationLogo';
export default {
    components: {ApplicationLogo},
    props: {
        showHeader: {
            type: Boolean,
            required: false,
            default: false,
        }
    }
}
</script>

<style scoped>
</style>
