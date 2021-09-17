<template>
    <popup
        v-if="visible"
        :title="__('ახალი კომპანიის დამატება')"
    >
        <form class="form margin-top-25" @submit.prevent="submit">
            <div class="form__group form__group--material">
                <c-input type="text" v-model="form.title"
                         :placeholder="__('კომპანიის სახელი')"/>
                <c-input-label for="title" :value="__('კომპანიის სახელი')"/>
                <c-input-error :message="form.errors.title" class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input type="text" v-model="form.identify_id"
                         :placeholder="__('საიდენთიფიკაციო კოდი')"/>
                <c-input-label for="identify" :value="__('საიდენთიფიკაციო კოდი')"/>
                <c-input-error :message="form.errors.identify_id" class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input type="text" v-model="form.address"
                         :placeholder="__('კომპანიის მისამართი')"/>
                <c-input-label for="address" :value="__('კომპანიის მისამართი')"/>
                <c-input-error :message="form.errors.address" class="mt-2"/>
            </div>
            <div class="form__group form__group--material margin-top-16">
                <c-input type="text" v-model="form.description"
                         :placeholder="__('კომპანიის აღწერა')"/>
                <c-input-label for="description" :value="__('კომპანიის აღწერა')"/>
                <c-input-error :message="form.errors.description" class="mt-2"/>
            </div>

            <c-button
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('დადასტურება') }}
            </c-button>
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

export default {
    components: {
        Popup,
        CInput,
        CInputError,
        CInputLabel,
        CButton
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: '',
                identify_id: '',
                address: '',
                description: ''
            }),
            visible: false,
        }
    },
    created() {
        this.visible = this.$page.props.loginModal;
    },
    methods: {
        submit() {
            this.$page.props.errors = {}
            this.form
                .post(this.route('company.store'), {
                    onFinish: () => {
                        if (!this.$page.props.errors || !Object.keys(this.$page.props.errors).length) {
                            this.visible = false;
                        }
                    }
                })
        },
        onShowPasswordResetPopup() {
            this.visible = false
            emitter.emit('showPasswordResetPopup')
        }
    },

    mounted() {
        emitter.on('showNewCompanyPopup', () => this.visible = true)
    }
}
</script>
