<template>
    <portal class="profile-page">
        <template v-slot:breadcrumb>
            <breadcrumb-item :active="true">
                {{ __('My Profile') }}
            </breadcrumb-item>
        </template>

        <template v-slot:main>
            <div class="col-md-12">
                <ul class="nav page-nav">
                    <li class="nav-item">
                        <inertia-link :href="route('profile.show')" class="nav-link active">{{ __('Profile') }}</inertia-link>
                    </li>
                    <li class="nav-item ml-2">
                        <inertia-link :href="route('company.index')" class="nav-link">{{ __('My Companies') }}</inertia-link>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 mt-4">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <update-profile-information-form :options="$page.props.options" :user="$page.props.user" />
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <update-password-form />
                </div>
            </div>
        </template>
    </portal>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteUserForm from './DeleteUserForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'
    import Portal from "@/Layouts/Portal";
    import BreadcrumbItem from "@/Components/BreadcrumbItem";

    export default {
        props: ['sessions'],

        components: {
            BreadcrumbItem,
            Portal,
            AppLayout,
            DeleteUserForm,
            JetSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
        },
    }
</script>
