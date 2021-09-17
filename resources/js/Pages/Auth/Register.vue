<template>
    <authenticate custom-class="">
        <template v-slot:main>
            <div class="register container flex justify-center">
                <div class="width-416 width-xs-full margin-top-10">
                    <h2>{{ __('რეგისტრაცია') }}</h2>
                    <p class="padding-top-34">{{ __('აირჩიეთ როგორ გსურთ რეგისტრაცია') }}</p>

                    <div class="register__controls flex margin-top-24">
                        <button
                            class="button button--light is-outline font-size-xs width-198 width-xs-half padding-0 border-radius-10"
                            :class="{'border-color-middle-green-yellow': mode === 'personal', 'color-middle-green-yellow': mode === 'personal'}"
                            @click="setMode('personal')"
                        >
                            <div class="flex direction-column justify-center padding-y-20">
                                <div class="button__icon margin-bottom-10">
                                    <user-icon width="30" height="30"/>
                                </div>
                                {{ __('ფიზიკური პირი') }}
                            </div>
                        </button>

                        <button
                            class="button button--light is-outline font-size-xs width-198 width-xs-half margin-left-24 padding-0 border-radius-10"
                            :class="{'border-color-middle-green-yellow': mode === 'company', 'color-middle-green-yellow': mode === 'company'}"
                            @click="setMode('company')"
                        >
                            <div class="flex direction-column justify-center padding-y-20">
                                <div class="button__icon margin-bottom-10">
                                    <users-icon width="30" height="30"/>
                                </div>
                                {{ __('კომპანია') }}
                            </div>
                        </button>
                    </div>

                    <div
                        v-if="mode"
                        class="register__content margin-top-26"
                    >
                        <form
                            class="form width-full"
                            @submit.prevent="submit"
                        >
                            <div
                                v-if="mode === 'company'"
                                class="font-size-md"
                            >
                                {{ __('პირადი ინფორმაცია') }}
                            </div>

                            <div class="form__group form__group--material margin-top-24">
                                <c-input
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                    :placeholder="__('თქვენი სახელი*')"/>
                                <c-input-label for="name" :value="__('თქვენი სახელი*')"/>
                                <c-input-error :message="form.errors.name" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input
                                    id="surname"
                                    type="text"
                                    v-model="form.surname"
                                    :placeholder="__('გვარი*')"/>
                                <c-input-label for="surname" :value="__('გვარი*')"/>
                                <c-input-error :message="form.errors.surname" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">

                                <c-input id="phoneNumber" type="text" v-model="form.phone_number"
                                         :placeholder="__('ტელეფონის ნომერი*')"/>
                                <c-input-label for="phone_number" :value="__('ტელეფონის ნომერი*')"/>
                                <c-input-error :message="form.errors.phone_number" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input id="email" type="email" v-model="form.email" :placeholder="__('მეილი*')"/>
                                <c-input-label for="email" :value="__('მეილი*')"/>
                                <c-input-error :message="form.errors.email" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input id="password" type="password" v-model="form.password"
                                         :placeholder="__('პაროლი*')"/>
                                <c-input-label for="password" :value="__('პაროლი*')"/>
                                <c-input-error :message="form.errors.password" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input id="passwordConfirmation" type="password" v-model="form.password_confirmation"
                                         :placeholder="__('გაიმეორეთ პაროლი*')"/>
                                <c-input-label for="password_confirmation" :value="__('გაიმეორეთ პაროლი*')"/>
                                <c-input-error :message="form.errors.password_confirmation" class="mt-2"/>
                            </div>

                            <div
                                v-if="mode === 'company'"
                                class="margin-top-32"
                            >
                                <div class="font-size-md padding-bottom-8">{{ __('კომპანიის ინფორმაცია') }}</div>

                                <template
                                    v-for="(_,index) in companyCount"
                                    :key="index"
                                >
                                    <div class="form__group form__group--material margin-top-16">
                                        <input :id="`${index}-companyTitle`"
                                               type="text"
                                               class="form__element"
                                               v-on:change="changeDynamic(index,'title','company')"
                                               v-model="form.company[index].title"
                                               :placeholder="__('კომპანიის სახელი')"/>
                                        <c-input-label :value="__('კომპანიის სახელი')"/>
                                        <c-input-error :message="getDynamicErrors(index,'title','company')"
                                                       class="mt-2"/>
                                    </div>
                                    <div class="form__group form__group--material margin-top-16">
                                        <input :id="`${index}-companyIdentify`"
                                               type="text"
                                               class="form__element"
                                               v-on:change="changeDynamic(index,'identify_id','company')"
                                               v-model="form.company[index].identify_id"
                                               :placeholder="__('კომპანიის საიდენტიფიკაციო კოდი')"/>
                                        <c-input-label :value="__('კომპანიის საიდენტიფიკაციო კოდი')"/>
                                        <c-input-error :message="getDynamicErrors(index,'identify_id','company')"
                                                       class="mt-2"/>
                                    </div>
                                    <div class="form__group form__group--material margin-top-16">
                                        <input :id="`${index}-companyAddress`"
                                               type="text"
                                               class="form__element"
                                               v-on:change="changeDynamic(index,'address','company')"
                                               v-model="form.company[index].address"
                                               :placeholder="__('კომპანიის მისამართი')"/>
                                        <c-input-label :value="__('კომპანიის მისამართი')"/>
                                        <c-input-error :message="getDynamicErrors(index,'address','company')"
                                                       class="mt-2"/>
                                    </div>
                                    <div class="form__group form__group--material margin-top-16">
                                        <input :id="`${index}-companyDescription`"
                                               type="text"
                                               class="form__element"
                                               v-on:change="changeDynamic(index,'description','company')"
                                               v-model="form.company[index].description"
                                               :placeholder="__('კომპანიის აღწერა')">
                                        <c-input-label :value="__('კომპანიის აღწერა')"/>
                                        <c-input-error :message="getDynamicErrors(index,'description','company')"
                                                       class="mt-2"/>
                                    </div>
                                </template>

                                <div class="showable">
                                    <button
                                        type="button"
                                        class="showable__title font-size-md margin-top-34 padding-bottom-8"
                                        :class="{'is-active': showHumans}"
                                        @click="onCollapseHumans"
                                    >
                                        {{ __('თანამშრომლების ინფორმაცია') }}
                                    </button>

                                    <div
                                        v-if="showHumans"
                                        class="showable__body"
                                    >
                                        <p class="color-black font-size-xs opacity-50 line-height-default padding-top-8">
                                            {{
                                                __('თანამშრომლების ინფორმაცია შეგიძლიათ შეავსოთ როგორც ახლა. ასევე შემდგომ თქვენი პირადი პროფილიდან')
                                            }}
                                        </p>

                                        <div class="margin-minus-12">
                                            <vue-collapsible-panel-group
                                                v-if="employeeCount"
                                                base-color="#9DBF53"
                                            >
                                                <vue-collapsible-panel v-for="(_,index) in employeeCount"
                                                                       :key="index"
                                                                       v-if="employeeCount">
                                                    <template #title>
                                                        <p
                                                            class="color-black font-size-sm"
                                                            v-bind:class="{ 'validation_error': getDynamicErrors(index,'name','company_employee') || getDynamicErrors(index,'email','company_employee') }"
                                                        >
                                                        <span v-if="form.company_employee.length">
                                                            {{form.company_employee[index].name}}
                                                        </span>
                                                        </p>
                                                    </template>
                                                    <template #content>
                                                        <div class="form__group form__group--material margin-top-16">
                                                            <input :id="`${index}-employeeName`"
                                                                   type="text"
                                                                   class="form__element"
                                                                   v-on:change="changeDynamic(index,'name','company_employee')"
                                                                   v-model="form.company_employee[index].name"
                                                                   :placeholder="__('სრული სახელი')"/>
                                                            <c-input-label :value="__('სრული სახელი')"/>
                                                            <c-input-error
                                                                :message="getDynamicErrors(index,'name','company_employee')"
                                                                class="mt-2"/>
                                                        </div>
                                                        <div class="form__group form__group--material margin-top-16">
                                                            <input :id="`${index}-employeeEmail`"
                                                                   type="email"
                                                                   class="form__element"
                                                                   v-on:change="changeDynamic(index,'email','company_employee')"
                                                                   v-model="form.company_employee[index].email"
                                                                   :placeholder="__('მეილი')"/>
                                                            <c-input-label :value="__('მეილი')"/>
                                                            <c-input-error
                                                                :message="getDynamicErrors(index,'email','company_employee')"
                                                                class="mt-2"/>
                                                        </div>
                                                        <div class="form__group form__group--material margin-top-16">
                                                            <input :id="`${index}-employeeRole`"
                                                                   type="text"
                                                                   class="form__element"
                                                                   v-on:change="changeDynamic(index,'role','company_employee')"
                                                                   v-model="form.company_employee[index].role"
                                                                   :placeholder="__('კომპანიაში როლი')"/>
                                                            <c-input-label :value="__('კომპანიაში როლი')"/>
                                                            <c-input-error
                                                                :message="getDynamicErrors(index,'role','company_employee')"
                                                                class="mt-2"/>
                                                        </div>
                                                        <div class="form__group form__group--material margin-top-16">
                                                            <input :id="`${index}-employeeRole`"
                                                                   type="text"
                                                                   class="form__element"
                                                                   v-on:change="changeDynamic(index,'phone','company_employee')"
                                                                   v-model="form.company_employee[index].phone"
                                                                   :placeholder="__('მობილური ტელეფონი')"/>
                                                            <c-input-label :value="__('მობილური ტელეფონი')"/>
                                                            <c-input-error
                                                                :message="getDynamicErrors(index,'phone','company_employee')"
                                                                class="mt-2"/>
                                                        </div>
                                                    </template>
                                                </vue-collapsible-panel>
                                            </vue-collapsible-panel-group>

                                        </div>
                                        <button
                                            type="button"
                                            class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                                            @click="onNewHuman"
                                        >
                                            {{ __('სხვა თანამშრომლის დამატება') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form__group form__group--material margin-top-34">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkBox" v-model="form.terms">
                                    <label for="checkBox" class="font-size-2xs">
                                        {{ __('ვეთანხმები') }} <a href="#"
                                                                  class="button button--link font-size-2xs font-weight-400">
                                        {{ __('წესებს და პირობებს') }}</a>
                                    </label>
                                    <c-input-error :message="form.errors.terms" class="mt-2"/>
                                </div>
                            </div>
                            <c-button
                                class="button button--primary button--shadow button--border width-full margin-top-24"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ __('რეგისტრაცია') }}
                            </c-button>
                        </form>
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
import CSelect from "@/CoreUi/components/Select";
import CCheckbox from "@/CoreUi/components/Checkbox";
import Multiselect from '@vueform/multiselect'
import UserIcon from "@/Components/Web/Icons/User";
import UsersIcon from "@/Components/Web/Icons/Users";
import {
    VueCollapsiblePanelGroup,
    VueCollapsiblePanel,
} from '@dafcoe/vue-collapsible-panel'
import '@dafcoe/vue-collapsible-panel/dist/vue-collapsible-panel.css'

export default {
    components: {
        CSuccessLabel,
        Authenticate,
        CInput,
        CInputError,
        CValidationErrors,
        CButton,
        CInputLabel,
        CSelect,
        CCheckbox,
        Multiselect,
        UserIcon,
        UsersIcon,
        VueCollapsiblePanelGroup,
        VueCollapsiblePanel,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                surname: '',
                email: '',
                phone_number: '',
                password: '',
                password_confirmation: '',
                terms: false,
                company: [
                    {
                        title: '',
                        description: ''
                    }
                ],
                company_employee: [],
                legal_person: false,
            }),
            mode: '',
            showHumans: false,
            companyCount: 1,
            employeeCount: 0,
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        },
        setMode(value) {
            this.mode = value;
            this.form.legal_person = value === 'company' ?? false;
        },
        onNewHuman() {
            this.form.company_employee = [...this.form.company_employee, {
                name: '',
                email: '',
                role: '',
                phone: ''
            }]
            this.employeeCount++;
        },

        onCollapseHumans() {
            if (this.showHumans) {
                this.form.company_employee = [];
            } else {
                this.form.company_employee = [
                    {
                        name: '',
                        email: '',
                        role: '',
                        phone: ''
                    }
                ];
                this.employeeCount = 1;
                this.employeeCollapse = [true];

            }
            this.showHumans = !this.showHumans;
        },
        getDynamicErrors(index, value, module) {
            let key = `${module}.${index}.${value}`
            return this.form.errors[key] ?? '';
        },
        changeDynamic(index, key, module) {
            this.form[module][index][key] = event.target.value
        }
    },

}
</script>

