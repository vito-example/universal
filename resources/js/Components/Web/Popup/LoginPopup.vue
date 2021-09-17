<template>
    <popup
        v-if="visible"
        :title="__('ავტორიზაცია')"
    >
        <form class="form margin-top-25" @submit.prevent="submit">
            <div class="form__group form__group--material">
                <c-input id="email" type="email" v-model="form.email" :placeholder="__('შეიყვანეთ მეილი')" autocomplete="off">
                </c-input>
                <c-input-label for="email" :value="__('შეიყვანეთ მეილი')"/>
                <c-input-error :message="form.errors.email" class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input id="password"
                         type="password"
                         v-model="form.password"
                         autocomplete="current-password"
                         :placeholder="__('პაროლი')"
                >
                </c-input>
                <c-input-label for="password" :value="__('პაროლი')"/>
                <c-input-error :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="flex space-between margin-top-24">
                <inertia-link
                    :href="route('register')"
                    class="button button--link color-black font-size-xs font-weight-600 text-decoration-none"
                >
                    {{ __('რეგისტრაცია') }}
                </inertia-link>

                <button
                    type="button"
                    class="button button--link color-black font-size-xs font-weight-600 text-decoration-none"
                    @click="onShowPasswordResetPopup"
                >
                    {{ __('დაგავიწყდა პაროლი?') }}
                </button>
            </div>

            <c-button
                type="submit"
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('ავტორიზაცია') }}
            </c-button>
        </form>

        <div class="diver">
            <div class="diver__title">{{__('ან')}}</div>
        </div>

        <div class="row">
            <div class="col-6 col-lg-6 col-xs-12">
                <a
                        :href="route('login.social','facebook')"
                        class="button button--facebook button--outline font-size-xs hover-color-white padding-y-14 padding-x-0 width-full flex justify-center items-center"
                >
                    <div class="button__icon color-facebook padding-right-14">
                        <facebook-icon width="19" height="23" />
                    </div>
                    {{__('Facebook ავტორიზაცია')}}
                </a>
            </div>

            <div class="col-6 col-lg-6 col-xs-12 margin-top-xs-12">
                <a
                        :href="route('login.social','google')"
                        type="button"
                        class="button button--gmail button--outline font-size-xs hover-color-white padding-y-14 padding-x-0 width-full flex justify-center items-center"
                >
                    <div class="button__icon color-gmail padding-right-14">
                        <gmail-icon width="23" height="23" />
                    </div>
                    {{__('Gmail ავტორიზაცია')}}
                </a>
            </div>
        </div>
    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CButton from "@/CoreUi/components/Button";
import FacebookIcon from "@/Components/Web/Icons/Facebook";
import GmailIcon from "@/Components/Web/Icons/Gmail";

export default {
    components: {
        Popup,
        CInput,
        CInputError,
        CInputLabel,
        CButton,
        FacebookIcon,
        GmailIcon
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: ''
            }),
            visible: true,
        }
    },
    created() {
        this.visible = this.$page.props.loginModal;
    },
    methods: {
        submit() {
            this.$page.props.errors = {}
            this.form
                .transform(data => ({
                    ...data
                }))
                .post(this.route('login'), {

                })
        },
        onShowPasswordResetPopup() {
            this.visible = false
            emitter.emit('showPasswordResetPopup')
        }
    },

    mounted() {
        emitter.on('showLoginPopup', () => this.visible = true)
    }
}
</script>
