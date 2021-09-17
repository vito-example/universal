<template>
    <header class="c-header c-header-light c-header-fixed">
        <button class="header-toggle" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true" @click="toggleMobileSidebar">
            <i class="icon_menu"></i>
        </button>
        <ul class="c-header-nav mfs-auto">
            <li class="c-header-nav-item px-3 c-d-legacy-none">
                <button class="c-class-toggler c-header-nav-btn" type="button" id="header-tooltip" data-target="body" data-class="c-dark-theme" data-toggle="c-tooltip" data-placement="bottom" title="Toggle Light/Dark Mode">
                    <svg class="c-icon c-d-dark-none">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-moon"></use>
                    </svg>
                    <svg class="c-icon c-d-default-none">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-sun"></use>
                    </svg>
                </button>
            </li>
        </ul>
        <ul class="c-header-nav">
            <template v-if="isAuth()">
<!--                <li>-->
<!--                    <form @submit.prevent="logout">-->
<!--                        <c-button>-->
<!--                            {{ __('Log out') }}-->
<!--                        </c-button>-->
<!--                    </form>-->
<!--                </li>-->

                <li class="c-header-profile d-flex align-items-center">
                    <inertia-link :href="route('profile.show')" class="d-flex align-items-center">
                        <span class="badge rounded-pill avatar" v-if="!profilePhotoUrl">
                            {{ nameInitial() }}
                        </span>
                        <span v-else class="badge rounded-pill avatar">
                            <img :src="profilePhotoUrl">
                        </span>

                        <div class="c-header-profile-info font-weight-bold ml-2">
                            {{ firstName() }}
                        </div>
                    </inertia-link>

                    <form @submit.prevent="logout">
                        <c-button class="logout">
                            <i class="pe-7s-power"></i>
                        </c-button>
                    </form>
                </li>
            </template>
            <template v-else>
                <li class="header-login-btn">
                    <inertia-link :href="route('login')">
                        <i class="icon icon-user mr-1"></i> <span class="d-md-down-none">{{ __('Login') }}</span>
                    </inertia-link>
                </li>
            </template>
        </ul>
        <div class="c-subheader justify-content-between px-3">
            <ol class="breadcrumb border-0 m-0 px-0">
                <slot name="breadcrumb"></slot>
            </ol>
        </div>
    </header>
</template>

<script>
import emitter from "@/Plugins/bus";
import CButton from "@/CoreUi/components/Button";
import Button from "@/Jetstream/Button";
export default {
    components: {
        Button,
        CButton
    },
    computed: {
        profilePhotoUrl () {
            return this.$page.props.user ? this.$page.props.user.profile_photo_url : ''
        }
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'),{},{
                onSuccess: () => {
                    this.clearBetaShowModal()
                    window.location.reload()
                }
            });
        },
        toggleMobileSidebar () {
            emitter.emit('toggleMobileSidebar')

            if (window.innerWidth < 992) {
                emitter.emit('showOverlay')
            }
            // emitter.emit('showOverlay')
        }
    },
}
</script>
