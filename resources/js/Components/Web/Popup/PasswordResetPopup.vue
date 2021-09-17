<template>
    <popup
        v-if="visible"
        title="დაგავიწყდა პაროლი?"
    >
        <form class="form margin-top-25" @submit.prevent="submit">
            <div class="form__group form__group--material">
                <c-input @keypress="isGeorgianPhoneNumber($event,form.phone_number)"
                         :placeholder="__('შეიყვანეთ ტელეფონი')"
                         id="phone_number" type="text" v-model="form.phone_number" autofocus>
                </c-input>
                <c-input-label for="phone_number" :value="__('ტელეფონის ნომერი')"/>
                <c-input-error :message="form.errors.phone_number" class="mt-2"/>
            </div>
            <c-button
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('კოდის მოთხოვნა') }}
            </c-button>
        </form>
        <form @submit.prevent="passwordUpdate" v-if="sentVerifyCode" class="form margin-top-25">
            <div class="form__group form__group--material">
                <c-input @keypress="isNumberValidate($event)"
                         id="token"
                         type="text"
                         v-model="form.token"
                         :placeholder="__('ვერიფიკაციის კოდი')"
                         autofocus
                >
                </c-input>
                <c-input-label for="token" :value="__('ვერიფიკაციის კოდი')"/>
                <c-input-error :message="form.errors.token" class="mt-2"/>
            </div>
            <div class="form__group form__group--material margin-top-16">
                <c-input
                    id="password"
                    type="password"
                    v-model="form.password"
                    autocomplete="current-password"
                    :placeholder="__('ახალი პაროლი')"
                >
                </c-input>
                <c-input-label for="password" :value="__('ახალი პაროლი')"/>
                <c-input-error :message="form.errors.password" class="mt-2"/>
            </div>
            <div class="form__group form__group--material margin-top-16">
                <c-input
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    :placeholder="__('გაიმეორეთ პაროლი')"
                    autocomplete="current-password"
                >
                </c-input>
                <c-input-label
                    for="password_confirmation"
                    :value="__('გაიმეორეთ პაროლი')"/>
                <c-input-error :message="form.errors.password_confirmation" class="mt-2"/>
            </div>

            <c-button
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('პაროლის განახლება') }}
            </c-button>
        </form>

    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CValidationErrors from "@/CoreUi/components/ValidationErrors";
import CButton from "@/CoreUi/components/Button";
import CInputLabel from "@/CoreUi/components/InputLabel";

export default {
    components: {
        Popup,
        CInput,
        CInputError,
        CValidationErrors,
        CButton,
        CInputLabel
    },
    data() {
        return {
            form: this.$inertia.form({
                phone_number: '',
                token: '',
                password: '',
                password_confirmation: ''
            }),
            sentVerifyCode: false,
            visible: false,

        }
    },
    methods: {
        submit() {
            this.$page.props.errors = {}
            this.form.post(this.route('password.phone'), {
                onFinish: () => {
                    if (!this.$page.props.errors || !Object.keys(this.$page.props.errors).length) {
                        this.sentVerifyCode = true
                    }
                }
            })
        },
        passwordUpdate() {
            this.form.post(this.route('password.update'))
        }
    },

    mounted() {
        emitter.on('showPasswordResetPopup', () => this.visible = true)
    }
}
</script>
