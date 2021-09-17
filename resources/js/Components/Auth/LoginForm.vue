<template>
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <c-validation-errors />
                    <c-success-label :status="status"></c-success-label>
                    <h1>{{ __('Login') }}</h1>
                    <p class="text-muted">{{ __('Sign In to your account') }}</p>
                    <form @submit.prevent="submit">

                        <div class="form-group">
                            <c-input-label for="phone_number" :value="__('Phone Number')" />
                            <c-input  @keypress="isGeorgianPhoneNumber($event,form.phone_number)"
                                      id="phone_number" type="text" v-model="form.phone_number" autofocus>
                            </c-input>
                            <c-input-error :message="form.errors.phone_number" class="mt-2"/>
                        </div>
                        <div class="form-group">
                            <c-input-label for="password" :value="__('Password')" />
                            <c-input  id="password" type="password" v-model="form.password" autocomplete="current-password">
                            </c-input>
                            <c-input-error :message="form.errors.password" class="mt-2"/>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <c-button
                                    class="btn btn-primary px-4"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{ __('Login')}}
                                </c-button>
                            </div>
                            <div class="col-6 text-right">
                                <inertia-link v-if="canResetPassword" :href="route('password.request')"
                                              class="btn btn-link px-0">
                                    {{ __('Forget Password?') }}
                                </inertia-link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div class="mt-3">
                        <h2 class="mb-4">{{ __('Sign up') }}</h2>
                        <inertia-link :href="route('register')"
                                      class="btn btn-lg btn-outline-light mt-4">
                            {{ __('Register now!') }}
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Authenticate from "@/Layouts/Authenticate";
import CInput from "@/CoreUi/components/Input";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CInputError from "@/CoreUi/components/InputError";
import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
import CValidationErrors from "@/CoreUi/components/ValidationErrors";
import CButton from "@/CoreUi/components/Button";
import LoginForm from "@/Components/Auth/LoginForm";

export default {
    components: {
        LoginForm,
        CSuccessLabel,
        Authenticate,
        CInput,
        CInputError,
        CValidationErrors,
        CButton,
        CInputLabel
    },
    props: {
        canResetPassword: Boolean,
        status: String
    },
    data() {
        return {
            form: this.$inertia.form({
                phone_number: '',
                password: ''
            })
        }
    },

    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ... data
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
        }
    }
}
</script>
