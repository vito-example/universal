<template>
    <authenticate custom-class="reset-page">
        <template v-slot:main>
            <div class="col-md-5">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <c-success-label :status="status"></c-success-label>
                            <div class="d-flex">
                                <div class="card-icon">
                                    <i class="icon icon-padlock"></i>
                                </div>

                                <div class="card-title">
                                    {{ __('Reset password') }}

                                    <p class="text-muted">{{ __('You can log in') }}
                                        <inertia-link :href="route('login')"
                                                      class="btn btn-link px-0">
                                            {{ __('Here') }}
                                        </inertia-link>
                                    </p>
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
                                <div class="row">
                                    <div class="col-12">
                                        <c-button
                                            class="btn btn-primary text-uppercase font-weight-bold btn-block px-4"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            {{ __('Phone Number password reset code') }}
                                        </c-button>
                                    </div>
                                </div>
                            </form>

                            <form @submit.prevent="passwordUpdate" v-if="sentVerifyCode">

                                <div class="form-group">
                                    <c-input-label for="token" :value="__('Verify code')" />
                                    <c-input  @keypress="isNumberValidate($event)"
                                              id="token" type="text" v-model="form.token" autofocus>
                                    </c-input>
                                    <c-input-error :message="form.errors.token" class="mt-2"/>
                                </div>
                                <div class="form-group">
                                    <c-input-label for="password" :value="__('New Password')" />
                                    <c-input  id="password" type="password" v-model="form.password" autocomplete="current-password">
                                    </c-input>
                                    <c-input-error :message="form.errors.password" class="mt-2"/>
                                </div>
                                <div class="form-group">
                                    <c-input-label for="password_confirmation" :value="__('Password Confirmation')" />
                                    <c-input  id="password_confirmation" type="password" v-model="form.password_confirmation" autocomplete="current-password">
                                    </c-input>
                                    <c-input-error :message="form.errors.password_confirmation" class="mt-2"/>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <c-button
                                            class="btn btn-primary text-uppercase font-weight-bold px-4"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            {{ __('Update Password') }}
                                        </c-button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </template>
    </authenticate>
</template>
<script>
import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
import Authenticate from "@/Layouts/Authenticate";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CValidationErrors from "@/CoreUi/components/ValidationErrors";
import CButton from "@/CoreUi/components/Button";
import CInputLabel from "@/CoreUi/components/InputLabel";

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
        status: String
    },

    data() {
        return {
            form: this.$inertia.form({
                phone_number: '',
                token: '',
                password: '',
                password_confirmation: ''
            }),
            sentVerifyCode: false
        }
    },

    methods: {
        submit() {
            this.$page.props.errors = {}
            this.form.post(this.route('password.phone'),{
                onFinish: () => {
                    if (!this.$page.props.errors || !Object.keys(this.$page.props.errors).length) {
                        this.sentVerifyCode = true
                    }
                }
            })
        },
        passwordUpdate () {
            this.form.post(this.route('password.update'))
        }
    }
}
</script>
