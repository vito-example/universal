<template>
    <popup
        v-if="visible"
        :title="__('ახალი თანამშრომლის დამატება')"
    >
        <form class="form margin-top-25" @submit.prevent="submit">
            <SelectObject
                v-if="this.companies.length"
                :options="this.companies"
                class="select"
                :model="'company_id'"
                @input="getSelectedValue"
            />

            <div class="form__group form__group--material margin-top-16">
                <c-input :id="`employeeName`"
                         type="text"
                         class="form__element"
                         v-model="form.name"
                         :placeholder="__('სრული სახელი')"/>
                <c-input-label :value="__('სრული სახელი')"/>
                <c-input-error
                    :message="form.errors.name ?? ''"
                    class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input :id="`employeeEmail`"
                         type="email"
                         class="form__element"
                         v-model="form.email"
                         :placeholder="__('მეილი')"/>
                <c-input-label :value="__('მეილი')"/>
                <c-input-error
                    :message="form.errors.email"
                    class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input :id="`employeeRole`"
                         type="text"
                         class="form__element"
                         v-model="form.role"
                         :placeholder="__('როლი კომპანიაში')"/>
                <c-input-label :value="__('როლი კომპანიაში')"/>
                <c-input-error
                    :message="form.errors.role"
                    class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input :id="`employeePhone`"
                         type="text"
                         class="form__element"
                         v-model="form.phone"
                         :placeholder="__('ტელეფონის ნომერი')"/>
                <c-input-label :value="__('ტელეფონის ნომერი')"/>
                <c-input-error
                    :message="form.errors.phone"
                    class="mt-2"/>
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
import SelectObject from "@/Components/Web/Select/SelectObject";

export default {
    components: {
        Popup,
        CInput,
        CInputError,
        CInputLabel,
        CButton,
        SelectObject
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                company_id: '',
                name: '',
                email: '',
                phone: '',
                role: ''
            }),
            companies: [],
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
                .post(this.route('employee.store'), {
                    onFinish: () => {
                        if (!this.$page.props.errors || !Object.keys(this.$page.props.errors).length) {
                            this.visible = false;
                        }
                    }
                })
        },
        getSelectedValue(item) {
            if (item.selected) {
                this.form[`${item.model}`] = item.selected.value;
            }
        }
    },

    mounted() {
        emitter.on('showNewColleaguePopup', (companies) => {
            this.companies = companies.map((el) => (
                {
                    label: el.title,
                    value: el.id
                }
            ))
            this.form.company_id = companies[0].id
            this.visible = true;
        })
    }
}
</script>
