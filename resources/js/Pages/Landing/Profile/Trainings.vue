<template>
    <landing>
        <template v-slot:main>
            <breadcrumb
                    :items="breadcrumb"
                    :active="__('ჩემი ტრენინგები')"
                    class="show-sm-down"
            />

            <div class="container">
                <div class="tab">
                    <profile-navigation active="trainings" />

                    <div class="tab__content">
                        <h4 class="color-black font-weight-bold margin-bottom-32">{{ __('ჩემი ტრენინგები') }}</h4>

                        <training-items :user="user" :trainings="trainings" />
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
import TrainingItems from "./TrainingItems"


export default {
    components: {
        Landing,
        Breadcrumb,
        ProfileNavigation,
        TrainingItems
    },

    props: {
        user: {
            type: Object
        },

        trainings: {
            type: Array
        }
    },

    inject: ["mq"],

    data () {
        return {
            breadcrumb: [
                {
                    label: 'პროფილი',
                    route: 'profile.show'
                }
            ]
        }
    },

    computed: {
        desktop () {
            return this.mq.lgPlus
        }
    },
}
</script>
