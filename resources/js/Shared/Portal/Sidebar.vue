<template>
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed" id="sidebar" :class="{ 'c-sidebar-show': mobileSidebar, ' c-sidebar-lg-show': sidebarVisible }">
        <div class="c-sidebar-brand">
            <a :href="route('home.index')" class="logo">
                <img :src="logoUrl" height="26" alt="Medu.ge">
            </a>
            <span class="beta-text">საიტი მუშაობს სატესტო რეჟიმში</span>
        </div>
        <ul class="c-sidebar-nav">
            <sidebar-nav-item>
                <inertia-link :href="route('home.index')"
                              class="c-sidebar-nav-link"
                              :class="isActive(['home.index']) ? 'c-active' : ''">
                    {{ __('Home') }}
                </inertia-link>
            </sidebar-nav-item>
            <sidebar-nav-item v-if="isAuth()">
                <inertia-link :href="route('profile.show')"
                              class="c-sidebar-nav-link"
                              :class="isActive(['profile.show']) ? 'c-active' : ''">
                    {{ __('Dashboard') }}
                </inertia-link>
            </sidebar-nav-item>
            <sidebar-nav-item>
                <inertia-link :href="route('event.index')"
                              class="c-sidebar-nav-link"
                              :class="isActive(['event.index', 'event.show','event.conference_url']) ? 'c-active' : ''">
                    {{ __('Events') }}
                </inertia-link>
            </sidebar-nav-item>
<!--            <sidebar-nav-item v-if="isAuth()">-->
<!--                <inertia-link :href="route('event.my')"-->
<!--                              class="c-sidebar-nav-link"-->
<!--                              :class="isActive(['event.my']) ? 'c-active' : ''">-->
<!--                    {{ __('My Events') }}-->
<!--                </inertia-link>-->
<!--            </sidebar-nav-item>-->
            <sidebar-nav-item v-if="isAuth()">
                <inertia-link :href="route('event.calendar.index')"
                              class="c-sidebar-nav-link"
                              :class="isActive(['event.calendar.index']) ? 'c-active' : ''">
                    {{ __('Calendar') }}
                </inertia-link>
            </sidebar-nav-item>
            <sidebar-nav-item>
                <inertia-link :href="route('about.index')"
                              class="c-sidebar-nav-link"
                              :class="isActive(['about.index']) ? 'c-active' : ''">
                    {{ __('About') }}
                </inertia-link>
            </sidebar-nav-item>
            <sidebar-nav-item>
                <inertia-link :href="route('blog.index')"
                              class="c-sidebar-nav-link"
                              :class="isActive(['blog.index']) ? 'c-active' : ''">
                    {{ __('Blog') }}
                </inertia-link>
            </sidebar-nav-item>
        </ul>
    </div>
</template>
<script>
import emitter from "@/Plugins/bus";
import SidebarNavItem from "@/Components/SidebarNavItem";
import CButton from "@/CoreUi/components/Button";
import {directive} from "vue3-click-away";
export default {
    components: {
        SidebarNavItem,
        CButton
    },
    directives: {
        ClickAway: directive
    },
    data () {
        return {
            sidebarVisible: true,
            mobileSidebar: false
        }
    },
    watch: {
        'mobileSidebar' (value) {
            //alert(value)
            if (!value) {
                // emitter.emit('showOverlay')
            }
        }
    },
    computed: {
        logoUrl () {
            return '/logo/white/' + this.$page.props.locale + '/logo.png'
        }
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'),{},{
                onSuccess: () => {
                    window.location.reload()
                }
            });
        },
        isActive(modules) {
            let active = false
            modules.forEach((page) => {
                if (this.route().current(page)) {
                    active = true
                }
            })
            return active
        },

        hideSidebar() {
            if (window.matchMedia('(max-width: 992px)')) {
                // this.mobileSidebar = false
            }
        }
    },

    mounted() {
        emitter.on('toggleMobileSidebar', () => {
            this.sidebarVisible = !this.sidebarVisible

            if (window.innerWidth < 992) {
                this.mobileSidebar = !this.mobileSidebar
            }
        })
    }
}
</script>
