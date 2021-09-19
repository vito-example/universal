<template>
    <header class="header">
        <div class="header_top_slider flex slick-initialized slick-slider">
            <a :href="'tel://' + getValueByFields(contact.fields,'phone')" target="_blank" class="flex info">
                <img src="/landing_resources/img/icons/header/1.png" alt=""/>
                <div>{{ getValueByFields(contact.fields, 'phone') }}</div>
            </a>
            <a class="flex info">
                <img src="/landing_resources/img/icons/header/2.png" alt=""/>
                <div>{{ getValueByFields(contact.fields, 'address') }}</div>
            </a>
            <a :href="'mailto:' + getValueByFields(contact.fields,'email')" target="_blank" class="flex info">
                <img src="/landing_resources/img/icons/header/3.png" alt=""/>
                <div>{{ getValueByFields(contact.fields, 'email') }}</div>
            </a>
            <div class="flex info">
                <img src="/landing_resources/img/icons/header/4.png" alt=""/>
                <div>{{ getValueByFields(contact.fields, 'working') }}</div>
            </div>
        </div>
        <div class="top flex">
            <div class="flex left" v-if="contact && contact.fields">
                <a :href="'tel://' + getValueByFields(contact.fields,'phone')" target="_blank" class="flex info">
                    <img src="/landing_resources/img/icons/header/1.png" alt=""/>
                    <div>{{ getValueByFields(contact.fields, 'phone') }}</div>
                </a>
                <a class="flex info">
                    <img src="/landing_resources/img/icons/header/2.png" alt=""/>
                    <div>{{ getValueByFields(contact.fields, 'address') }}</div>
                </a>
                <a :href="'mailto:' + getValueByFields(contact.fields,'email')" target="_blank" class="flex info">
                    <img src="/landing_resources/img/icons/header/3.png" alt=""/>
                    <div>{{ getValueByFields(contact.fields, 'email') }}</div>
                </a>
                <div class="flex info">
                    <img src="/landing_resources/img/icons/header/4.png" alt=""/>
                    <div>{{ getValueByFields(contact.fields, 'working') }}</div>
                </div>
            </div>
            <div class="flex right" v-if="social && social.fields">
                <template v-if="getValueByFields(social.fields,'facebook')">
                    <a :href="getValueByFields(social.fields,'facebook')" class="sm" target="_blank">
                        <img src="/landing_resources/img/icons/social-media/1.png" alt=""/>
                    </a>
                </template>
                <template v-if="getValueByFields(social.fields,'twitter')">
                    <a :href="getValueByFields(social.fields,'twitter')" target="_blank" class="sm">
                        <img src="/landing_resources/img/icons/social-media/2.png" alt=""/>
                    </a>
                </template>
                <template v-if="getValueByFields(social.fields,'linkedin')">
                    <a :href="getValueByFields(social.fields,'linkedin')" target="_blank" class="sm">
                        <img src="/landing_resources/img/icons/social-media/3.png" alt=""/>
                    </a>
                </template>
                <template v-if="getValueByFields(social.fields,'youtube')">
                    <a :href="getValueByFields(social.fields,'youtube')" target="_blank" class="sm">
                        <img src="/landing_resources/img/icons/social-media/4.png" alt=""/>
                    </a>
                </template>
            </div>
        </div>
        <div class="bottom border flex">
            <inertia-link :href="route('home.index')" class="logo red_bg part flex center">
                <div class="main medium">
                    {{ __('UNIVERSAL') }} <span class="black medium">{{ 'PROJECT' }}</span>
                </div>
                <div class="poppins">Road, Water, Architecture, Topography</div>
            </inertia-link>
            <div class="navbar part">
                <inertia-link :href="route('home.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('home.index',[],false)) ? 'current' : ''">
                        {{ __('Home') }}
                    </div>
                </inertia-link>
                <inertia-link :href="route('home.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('home.index',[],false)) ? 'current' : ''">{{ __('Projects') }}</div>
                </inertia-link>
                <inertia-link :href="route('blog.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('blog.index',[],false)) ? 'current' : ''">{{ __('Blog') }}</div>
                </inertia-link>
                <inertia-link :href="route('home.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('home.index',[],false)) ? 'current' : ''">{{ __('Team') }}</div>
                </inertia-link>
                <inertia-link :href="route('home.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('home.index',[],false)) ? 'current' : ''">{{ __('About us') }}</div>
                </inertia-link>
                <inertia-link :href="route('home.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('home.index',[],false)) ? 'current' : ''">{{ __('Contact us') }}</div>
                </inertia-link>
            </div>
            <button id="menu_btn"></button>
            <landing-language-selector/>
        </div>
    </header>

</template>

<script>
import emitter from "@/Plugins/bus"
import {Inertia} from "@inertiajs/inertia"

// components
import Logo from "@/Components/Layout/Logo/Logo"
import Dropdown from "@/Components/Web/Dropdown/Dropdown"
import BurgerMenu from "@/Components/Layout/Header/BurgerMenu"
import LandingLanguageSelector from "../../LandingLanguageSelector";

export default {
    name: "Header",

    components: {
        Logo,
        Dropdown,
        BurgerMenu,
        LandingLanguageSelector
    },

    data() {
        return {
            burgerMenuVisible: false
        }
    },
    computed: {
        contact() {
            return this.$page.props.layoutData ? this.$page.props.layoutData.contact : {}
        },
        social() {
            return this.$page.props.layoutData ? this.$page.props.layoutData.social : {}
        },
    },
    methods: {
        onShowLoginPopup() {
            emitter.emit('showLoginPopup')
        },
        getValueByFields(fields, key) {
            if (!fields[key]) {
                return ''
            }
            return fields[key].value
        },
        onShowBurgerMenu() {
            this.burgerMenuVisible = !this.burgerMenuVisible
        },
        activeMenu(route) {
            return window.location.pathname === route
        }
    },

    mounted() {
        Inertia.on('start', (event) => {
            this.burgerMenuVisible = false
        })
    }
}
</script>
