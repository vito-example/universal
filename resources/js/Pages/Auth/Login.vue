<template>
    <authenticate custom-class="login-page">
        <template v-slot:main>
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
<!--                            <c-validation-errors />-->
                            <c-success-label :status="status"></c-success-label>
                            <div class="d-flex">
                                <div class="card-icon">
                                    <i class="icon icon-user"></i>
                                </div>

                                <div class="card-title">
                                    {{ __('Login') }}

                                    <p class="text-muted pt-1">{{ __('Sign In to your account') }}</p>
                                </div>
                            </div>

                            <form @submit.prevent="submit">

                                <div class="form-group">
                                    <c-input-label for="phone_number" :value="__('Phone Number')" />
                                    <c-input  @keypress="isGeorgianPhoneNumber($event,form.phone_number)"
                                              :placeholder="__('Phone placeholder')"
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
                                    <div class="col-4">
                                        <c-button
                                            class="btn btn-primary text-uppercase font-weight-bold px-4"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            {{ __('Login')}}
                                        </c-button>
                                    </div>
                                    <div class="col-8 text-right">
                                        <inertia-link v-if="canResetPassword" :href="route('password.request')"
                                                      class="btn btn-link font-xs md:font-sm font-weight-bold px-0">
                                            {{ __('Forget Password?') }}
                                        </inertia-link>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card text-white card-register bg-primary py-5" style="width:44%">
                        <div class="card-body text-center">
                            <div class="mt-3">
                                <h5 class="mb-4">{{ __('Sign up') }}</h5>
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
    </authenticate>
</template>

<script>
import Authenticate from "@/Layouts/Authenticate";
import CInput from "@/CoreUi/components/Input";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CInputError from "@/CoreUi/components/InputError";
import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
import CValidationErrors from "@/CoreUi/components/ValidationErrors";
import CButton from "@/CoreUi/components/Button";

export default {
    components: {
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
            this.$page.props.errors = {}
            this.form
                .transform(data => ({
                    ... data
                }))
                .post(this.route('login'), {
                    onFinish: () => {
                        this.form.reset('password')
                    },
                })
        }
    }
}
</script>
