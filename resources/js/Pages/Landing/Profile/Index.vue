<template>
    <landing>
        <template v-slot:main>
            <breadcrumb
                    :active="__('პროფილი')"
                    class="show-sm-down"
            />

            <div class="container">
                <template v-if="desktop">
                    <div class="tab">
                        <profile-navigation active="trainings" />

                        <div class="tab__content">
                            <h4 class="color-black font-weight-bold margin-bottom-32">{{ __('ჩემი ტრენინგები') }}</h4>

                            <training-items :user="user" :trainings="trainings" />
                        </div>
                    </div>
                </template>

                <template v-else>
                    <h4 class="color-black font-weight-bold margin-y-32">{{ __('პროფილი') }}</h4>

                    <ul class="nav margin-top-16">
                        <li class="nav__item">
                            <inertia-link
                                    :href="route('profile.trainings')"
                                    class="nav__link font-weight-600 flex items-center"
                                    :title="__('ჩემი ტრენინგები')"
                            >
                                <div class="nav__icon line-height-0 padding-right-15">
                                    <arrow-secondary-right-icon
                                            :width="8"
                                            :height="14"
                                    />
                                </div>

                                {{ __('ჩემი ტრენინგები') }}
                            </inertia-link>
                        </li>

                        <li class="nav__item margin-top-32">
                            <inertia-link
                                    :href="route('profile.companies')"
                                    class="nav__link font-weight-600 flex items-center"
                                    :title="__('ჩემი კომპანიები')"
                            >
                                <div class="nav__icon line-height-0 padding-right-15">
                                    <arrow-secondary-right-icon
                                            :width="8"
                                            :height="14"
                                    />
                                </div>

                                {{ __('ჩემი კომპანიები') }}
                            </inertia-link>
                        </li>

                        <li class="nav__item margin-top-32">
                            <inertia-link
                                    :href="route('profile.colleagues')"
                                    class="nav__link font-weight-600 flex items-center"
                                    :title="__('ჩემი თანამშრომლები')"
                            >
                                <div class="nav__icon line-height-0 padding-right-15">
                                    <arrow-secondary-right-icon
                                            :width="8"
                                            :height="14"
                                    />
                                </div>

                                {{ __('ჩემი თანამშრომლები') }}
                            </inertia-link>
                        </li>

                        <li class="nav__item margin-top-32">
                            <inertia-link
                                    :href="route('profile.edit')"
                                    class="nav__link font-weight-600 flex items-center"
                                    :title="__('პირადი ინფორმაცია')"
                            >
                                <div class="nav__icon line-height-0 padding-right-15">
                                    <arrow-secondary-right-icon
                                            :width="8"
                                            :height="14"
                                    />
                                </div>

                                {{ __('პირადი ინფორმაცია') }}
                            </inertia-link>
                        </li>

                        <li class="nav__item margin-top-32">
                            <inertia-link
                                    :href="route('profile.security')"
                                    class="nav__link font-weight-600 flex items-center"
                                    :title="__('უსაფრთხოება')"
                            >
                                <div class="nav__icon line-height-0 padding-right-15">
                                    <arrow-secondary-right-icon
                                            :width="8"
                                            :height="14"
                                    />
                                </div>

                                {{ __('უსაფრთხოება') }}
                            </inertia-link>
                        </li>
                    </ul>
                </template>
            </div>
        </template>
    </landing>
</template>
<script>
import emitter from "@/Plugins/bus"
import Landing from "@/Layouts/Landing"
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import ArrowSecondaryRightIcon from "@/Components/Web/Icons/ArrowSecondaryRight"
import ProfileNavigation from "./ProfileNavigation"
import TrainingItems from "./TrainingItems"


export default {
    components: {
        Landing,
        Breadcrumb,
        ArrowSecondaryRightIcon,
        ProfileNavigation,
        TrainingItems
    },

    props: {
        user: {
            type: Array
        },
        companies: {
            type: Array
        },
        trainings: {
            type: Array
        },
        tab: {
            type: String
        }
    },

    inject: ["mq"],

    computed: {
        desktop () {
            return this.mq.lgPlus
        }
    },
}
</script>
