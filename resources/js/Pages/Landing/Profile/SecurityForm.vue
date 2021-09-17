<template>
    <form
            class="form width-416 width-sm-full"
            @submit.prevent="submitPassword"

    >
        <div class="form__group form__group--material">
            <c-input type="password" v-model="password.current_password"
                     :placeholder="__('არსებული პაროლი')"/>
            <c-input-label for="email" :value="__('არსებული პაროლი')"/>
            <c-input-error :message="password.errors.current_password" class="mt-2"/>
            <c-input-error
                    :message="password.errors.updatePassword ? password.errors.updatePassword.current_password : ''"
                    class="mt-2"/>
        </div>

        <div class="form__group form__group--material margin-top-16">
            <c-input type="password" v-model="password.password"
                     :placeholder="__('ახალი პაროლი')"/>
            <c-input-label for="email" :value="__('ახალი პაროლი')"/>
            <c-input-error :message="password.errors.password" class="mt-2"/>
        </div>

        <div class="form__group form__group--material margin-top-16">
            <c-input type="password" v-model="password.password_confirmation"
                     :placeholder="__('გაიმეორეთ პაროლი')"/>
            <c-input-label for="email" :value="__('გაიმეორეთ პაროლი')"/>
            <c-input-error :message="password.errors.password_confirmation" class="mt-2"/>
        </div>

        <c-button
                class="button button--primary button--shadow button--border width-full margin-top-24"
        >
            {{ __('პაროლის განახლება') }}
        </c-button>
    </form>
</template>

<script>
import CInput from "@/CoreUi/components/Input"
import CInputError from "@/CoreUi/components/InputError"
import CInputLabel from "@/CoreUi/components/InputLabel"
import CButton from "@/CoreUi/components/Button"

export default {
    components: {
        CInput,
        CInputError,
        CInputLabel,
        CButton,
    },

    props: {
        user: {
            type: Object
        }
    },

    data () {
        return {
            password: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submitPassword() {
            this.password.put(this.route('user-password.update'), {
                onFinish: () => console.log('updated'),
            })
        }
    }
}
</script>