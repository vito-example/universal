<template>
    <landing>
        <template v-slot:main>
            <breadcrumb
                    :items="breadcrumb"
                    :active="__('პირადი ინფორმაცია')"
                    class="show-sm-down"
            />

            <div class="container">
                <div class="tab">
                    <profile-navigation active="personal" />

                    <div class="tab__content">
                        <h4 class="color-black font-weight-bold margin-bottom-32">{{ __('პირადი ინფორმაცია') }}</h4>

                        <edit-form :user="user" />
                        <form @submit.prevent="verifySubmit" v-if="!user.email_verify" class="form width-416 width-sm-full">
                            <div class="mt-4 flex items-center justify-between">
                                <c-button class="button button--primary button--shadow button--border width-full margin-top-24" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{ __('ელ-ფოსტის ვერიფიკაცია') }}
                                </c-button>
                            </div>
                        </form>
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
import EditForm from "./EditForm"
import CButton from "@/CoreUi/components/Button";


export default {
    components: {
        Landing,
        Breadcrumb,
        ProfileNavigation,
        EditForm,
        CButton
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
            ],
            form: this.$inertia.form(),
        }
    },
    methods: {
        verifySubmit() {
            this.form.post(this.route('verify.email.create'),{
                onSuccess: () => {
                    emitter.emit('showEmailVerifyPopup')
                },
            })
        }
    }
}
</script>
