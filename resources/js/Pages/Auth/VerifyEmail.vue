<template>
    <authenticate custom-class="verify-page">
        <template v-slot:main>
            <div class="col-md-5">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <c-validation-errors/>
                            <h5>{{ __('Verify phone number') }}</h5>
                            <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
                                {{ __('New Verify code was sent') }}
                            </div>
                            <form @submit.prevent="submitVerify">
                                <div class="form-group">
                                    <c-input-label for="hash" :value="__('Verify Hash Code')"/>
                                    <c-input id="hash" type="text" v-model="verifyForm.hash" autofocus>
                                    </c-input>
                                    <c-input-error :message="verifyForm.errors.hash" class="mt-2"/>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <c-button
                                            class="btn btn-success text-uppercase font-weight-bold mr-3 px-2"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            {{ __('Customer Verify') }}
                                        </c-button>
                                    </div>
                                </div>
                            </form>
                            <form @submit.prevent="submit">
                                <div class="mt-4 flex items-center justify-between">
                                    <c-button class="btn btn-secondary text-uppercase font-weight-bold mr-3 px-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        {{ __('Resend verify code') }}
                                    </c-button>
                                    <inertia-link :href="route('logout')" method="post" as="button">
                                        <c-button class="btn btn-warning text-uppercase font-weight-bold mr-3 px-2">
                                            {{ __('Log out') }}
                                        </c-button>
                                    </inertia-link>
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
            verifyForm: this.$inertia.form({
                hash: ''
            }),
            form: this.$inertia.form(),
            status: ''
        }
    },

    methods: {
        submit() {
            this.form.errors = {}
            this.form.post(this.route('verification.send'),{
                onFinish: () => {
                    this.status = this.$page.props.status
                },
            })
        },
        submitVerify() {
            this.status = ''
            this.verifyForm.errors = {}
            this.verifyForm.post(this.route('verification.verify'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'passwords.sent';
        }
    }
}
</script>
