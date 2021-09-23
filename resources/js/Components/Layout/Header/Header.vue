<template>
    <header class="header">
        <div class="header_top_slider flex">
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
            <a :href="route('home.index')" class="logo red_bg part flex center">
                <div class="main medium">
                    {{ __('UNIVERSAL') }} <span class="black medium">{{ 'PROJECT' }}</span>
                </div>
                <div class="poppins">Road, Water, Architecture, Topography</div>
            </a>
            <div class="navbar part" :class="burgerMenuVisible ? 'open' : ''">
                <a :href="route('home.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('home.index',[],false)) ? 'current' : ''">
                        {{ __('home') }}
                    </div>
                </a>
                <inertia-link :href="route('project.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('project.index',[],false)) ? 'current' : ''">{{ __('Projects') }}</div>
                </inertia-link>
                <inertia-link :href="route('blog.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('blog.index',[],false)) ? 'current' : ''">{{ __('Blog') }}</div>
                </inertia-link>
                <inertia-link :href="route('team.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('team.index',[],false)) ? 'current' : ''">{{ __('Team') }}</div>
                </inertia-link>
                <inertia-link :href="route('about.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('about.index',[],false)) ? 'current' : ''">{{ __('About us') }}</div>
                </inertia-link>
                <inertia-link :href="route('service.index')">
                    <div class="nav main_blue flex center" :class="activeMenu(route('service.index',[],false)) ? 'current' : ''">{{ __('Services') }}</div>
                </inertia-link>
            </div>
            <button id="menu_btn" @click="burgerMenuVisible = !burgerMenuVisible" :class="burgerMenuVisible ? 'clicked' : ''"></button>
            <landing-language-selector/>
        </div>
    </header>

</template>

<script>
import emitter from "@/Plugins/bus"
import {Inertia} from "@inertiajs/inertia"

// components
import Logo from "@/Components/Layout/Logo/Logo"
import LandingLanguageSelector from "../../LandingLanguageSelector";

export default {
    name: "Header",

    components: {
        Logo,
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
        $(".header_top_slider").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            draggable: false,
            arrows: false,
            dots: false,
            speed: 3000,
            infinite: true,
            touchThreshold: 100,
            autoplay: true,
            autoplaySpeed: 0,
            cssEase: "linear ",
            responsive: [
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 2,
                    },
                },
            ],
        });

    }
}
</script>
