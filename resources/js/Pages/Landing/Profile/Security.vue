<template>
    <landing>
        <template v-slot:main>
            <breadcrumb
                    :items="breadcrumb"
                    :active="__('უსაფრთხოება')"
                    class="show-sm-down"
            />

            <div class="container">
                <div class="tab">
                    <profile-navigation active="security" />

                    <div class="tab__content">
                        <h4 class="color-black font-weight-bold margin-bottom-32">{{ __('უსაფრთხოება') }}</h4>

                        <security-form :user="user" />
                    </div>
                </div>
            </div>
        </template>
    </landing>
</template>
<script>
import emitter from "@/Plugins/bus"
import Landing from "@/Layouts/Landing"
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import ProfileNavigation from "./ProfileNavigation"
import SecurityForm from "./SecurityForm"


export default {
    components: {
        Landing,
        Breadcrumb,
        ProfileNavigation,
        SecurityForm
    },

    props: {
        user: {
            type: Object
        }
    },

    data () {
        return {
            breadcrumb: [
                {
                    label: 'პროფილი',
                    route: 'profile.show'
                }
            ]
        }
    }
}
</script>
