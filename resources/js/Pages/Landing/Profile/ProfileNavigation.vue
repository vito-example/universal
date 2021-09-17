<template>
    <div v-if="desktop" class="margin-top-10">
        <h1 class="font-size-xl font-weight-600 margin-top-20">{{ __('გამარჯობა') }}, {{ firstName() }}</h1>

        <ul class="nav nav--horizontal nav--tabs margin-top-16">
            <li
                    class="nav__item"
                    :class="{ 'is-active': active === 'trainings' }"
            >
                <inertia-link
                        :href="route('profile.trainings')"
                        class="nav__link"
                        :title="__('ჩემი ტრენინგები')"
                >
                    {{ __('ჩემი ტრენინგები') }}
                </inertia-link>
            </li>
            <li
                    class="nav__item"
                    :class="{ 'is-active': active === 'companies' }"
            >
                <inertia-link
                        :href="route('profile.companies')"
                        class="nav__link"
                        :title="__('ჩემი კომპანიები')"
                >
                    {{ __('ჩემი კომპანიები') }}
                </inertia-link>
            </li>
            <li
                    class="nav__item"
                    :class="{ 'is-active': active === 'colleagues' }"
            >
                <inertia-link
                        :href="route('profile.colleagues')"
                        class="nav__link"
                        :title="__('ჩემი თანამშრომლები')"
                >
                    {{ __('ჩემი თანამშრომლები') }}
                </inertia-link>
            </li>
            <li
                    class="nav__item"
                    :class="{ 'is-active': active === 'personal' }"
            >
                <inertia-link
                        :href="route('profile.edit')"
                        class="nav__link"
                        :title="__('პირადი ინფორმაცია')"
                >
                    {{ __('პირადი ინფორმაცია') }}
                </inertia-link>
            </li>
            <li
                    class="nav__item"
                    :class="{ 'is-active': active === 'security' }"
            >
                <inertia-link
                        :href="route('profile.security')"
                        class="nav__link"
                        :title="__('უსაფრთხოება')"
                >
                    {{ __('უსაფრთხოება') }}
                </inertia-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        active: {
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