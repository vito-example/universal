<template>
    <popup
        v-if="visible"
        :title="__('ვერიფიკაცია')"
    >
        <form @submit.prevent="submitVerify" class="form margin-top-25">
            <div class="form-group">
                <c-input-label for="hash" :value="__('Verify Hash Code')"/>
                <c-input id="hash" type="text" v-model="verifyForm.hash" autofocus>
                </c-input>
                <c-input-error :message="verifyForm.errors.hash" class="mt-2"/>
            </div>
            <div class="form-group">
                <c-button
                    class="button button--primary button--shadow button--border width-full margin-top-24"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ __('Customer Verify') }}
                </c-button>
            </div>
        </form>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <c-button class="button button--primary button--shadow button--border width-full margin-top-24" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ __('Resend verify code') }}
                </c-button>
            </div>
        </form>

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
            verifyForm: this.$inertia.form({
                hash: ''
            }),
            form: this.$inertia.form(),
            status: '',
            visible: true,
        }
    },
    created() {
        this.visible = this.$page.props.emailVerifyModal;
    },
    methods: {
        submit() {
            this.form.errors = {}
            this.form.post(this.route('verify.email.resend'),{
                onFinish: () => {
                    this.status = this.$page.props.status
                },
            })
        },
        submitVerify() {
            this.status = ''
            this.verifyForm.errors = {}
            this.verifyForm.post(this.route('verify.email.store'), {
                onSuccess: () => {
                    this.visible = false;
                }
            })
        },
    },
    mounted() {
        emitter.on('showEmailVerifyPopup', () => this.visible = true)
    }
}
</script>
