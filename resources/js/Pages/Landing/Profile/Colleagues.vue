<template>
    <landing>
        <template v-slot:main>
            <breadcrumb
                    :items="breadcrumb"
                    :active="__('ჩემი თანამშრომლები')"
                    class="show-sm-down"
            />

            <div class="container">
                <div class="tab">
                    <profile-navigation active="colleagues" />

                    <div class="tab__content">
                        <h4 class="color-black font-weight-bold margin-bottom-32">{{ __('ჩემი თანამშრომლები') }}</h4>

                        <div class="profile__list width-416 width-sm-full">
                            <colleague-items
                                    :user="user"
                                    :companies="companies"
                            />
                        </div>
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
import ColleagueItems from "./ColleagueItems"


export default {
    components: {
        Landing,
        Breadcrumb,
        ProfileNavigation,
        ColleagueItems
    },

    props: {
        user: {
            type: Object
        },

        companies: {
            type: Array
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
