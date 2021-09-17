<template>
    <landing>
        <template v-slot:main>
            <div class="trainings-single container margin-top-48">
                <div class="trainings-single__content">
                    <div class="trainings-single__left register-labels">
                        <div class="trainings-single__labels">
                            <div class="flex space-between margin-bottom-16" v-for="(item, key) in item.sessions"
                                 v-if="item.sessions.length">
                                <template v-if="item.can_register">
                                    <div class="label label--light-outline inline-flex items-center padding-y-8">
                                        <calendar-icon width="16" height="16"/>
                                        <span class="padding-left-6">{{ item.start_time }}</span>
                                    </div>
                                    <div class="label label--light-outline inline-flex items-center padding-y-8">
                                        {{ item.start_time_hour }}
                                    </div>
                                </template>
                            </div>

                            <div
                                class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8">
                                {{ __('ფასი') }}: {{ price }} ₾
                            </div>

                            <div
                                class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8"
                                v-if="item.place">
                                {{ __('ჩატარების ადგილი') }}: {{ item.place }}
                            </div>

                            <div
                                class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8"
                                v-if="item.phone">
                                {{ __('საკონტაქტო ნომერი') }}: {{ item.phone }}
                            </div>
                        </div>
                    </div>

                    <div class="trainings-single__right padding-left-134 padding-left-md-0">
                        <div class="width-452 width-xs-full" v-if="sessionOptions.length">
                            <h2>{{ __('რეგისტრაცია ტრენინგზე') }}</h2>
                            <p class="padding-top-34">{{ __('აირჩიეთ როგორ გსურთ რეგისტრაცია') }}</p>

                            <div class="register__controls flex margin-top-24">
                                <button
                                    class="button button--light is-outline font-size-xs width-214 width-xs-half padding-0 border-radius-10"
                                    :class="{'border-color-middle-green-yellow': mode === 'personal', 'color-middle-green-yellow': mode === 'personal'}"
                                    @click="setMode('personal')"
                                >
                                    <div class="flex direction-column justify-center padding-y-20">
                                        <div class="button__icon margin-bottom-10">
                                            <user-icon width="25" height="30"/>
                                        </div>
                                        {{ __('ჩემთვის') }}
                                    </div>
                                </button>

                                <button
                                    class="button button--light is-outline font-size-xs width-214 width-xs-half margin-left-24 padding-0 border-radius-10"
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
                            <div v-if="form.errors">
                                <p class="padding-top-34" style="color: red">{{ form.errors.validation_error }}</p>
                            </div>
                            <div v-if="message">
                                <p class="padding-top-34" style="color: #88aa3f">{{ message }}</p>
                            </div>
                            <div
                                v-if="mode"
                                class="register__content margin-top-26"
                            >
                                <form
                                    class="form width-full"
                                    @submit.prevent="submit"
                                >
                                    <SelectObject
                                        :options="sessionOptions"
                                        :default="sessionOptions[0]"
                                        class="select"
                                        :model="'session_id'"
                                        @input="getSelectedValue"
                                    />
                                    <div
                                        v-if="mode === 'company'"
                                        class="margin-top-16"
                                    >

                                        <div>
                                            <div v-if="!form.company_id">
                                                <div class="form__group form__group--material margin-top-16">
                                                    <div class="form__group-addon">
                                                        <button
                                                            type="button"
                                                            class="button button--link color-black text-decoration-none"
                                                            @click="onMyCompanies"
                                                        >
                                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                      d="M7 0.25C7.41421 0.25 7.75 0.585786 7.75 1V6.25H13C13.4142 6.25 13.75 6.58579 13.75 7C13.75 7.41421 13.4142 7.75 13 7.75H7.75V13C7.75 13.4142 7.41421 13.75 7 13.75C6.58579 13.75 6.25 13.4142 6.25 13V7.75H1C0.585786 7.75 0.25 7.41421 0.25 7C0.25 6.58579 0.585786 6.25 1 6.25H6.25V1C6.25 0.585786 6.58579 0.25 7 0.25Z"
                                                                      fill="#22282F"/>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <input :id="`companyTitle`"
                                                           type="text"
                                                           class="form__element"
                                                           v-model="form.company.title"
                                                           :placeholder="__('კომპანიის სახელი')"/>

                                                    <c-input-label :value="__('კომპანიის სახელი')"/>
                                                    <c-input-error :message="form.errors['company.title']"
                                                                   class="mt-2"/>
                                                </div>
                                                <div class="form__group form__group--material margin-top-16">
                                                    <input :id="`companyIdentify`"
                                                           type="text"
                                                           class="form__element"
                                                           v-model="form.company.identify_id"
                                                           :placeholder="__('კომპანიის საიდენტიფიკაციო კოდი')"/>
                                                    <c-input-label :value="__('კომპანიის საიდენტიფიკაციო კოდი')"/>
                                                    <c-input-error
                                                        :message="form.errors['company.identify_id']"
                                                        class="mt-2"/>
                                                </div>
                                                <div class="form__group form__group--material margin-top-16">
                                                    <input :id="`companyAddress`"
                                                           type="text"
                                                           class="form__element"
                                                           v-model="form.company.address"
                                                           :placeholder="__('კომპანიის მისამართი')"/>
                                                    <c-input-label :value="__('კომპანიის მისამართი')"/>
                                                    <c-input-error
                                                        :message="form.errors['company.address']"
                                                        class="mt-2"/>
                                                </div>
                                                <div class="form__group form__group--material margin-top-16">
                                                    <input :id="`companyDescription`"
                                                           type="text"
                                                           class="form__element"
                                                           v-model="form.company.description"
                                                           :placeholder="__('კომპანიის აღწერა')">
                                                    <c-input-label :value="__('კომპანიის აღწერა')"/>
                                                    <c-input-error
                                                        :message="form.errors['company.description']"
                                                        class="mt-2"/>
                                                </div>
                                            </div>
                                            <div v-else-if="selectedCompany">
                                                <p class="margin-top-14">{{ __('კომპანია') }}</p>
                                                <div class="flex space-between margin-top-14">
                                                    <div>
                                                        {{ selectedCompany ? selectedCompany.title : '' }}
                                                    </div>

                                                    <div>
                                                        <button
                                                            type="button"
                                                            class="button button--link color-black text-decoration-none"
                                                            @click="onMyCompanies"

                                                        >
                                                            <edit-icon width="24" height="24"/>
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="button button--link color-black text-decoration-none margin-left-16"
                                                            @click="emptyCompanyId"
                                                        >
                                                            <delete-icon width="24" height="24"/>
                                                        </button>
                                                    </div>
                                                </div>
                                                <p class="margin-top-14">{{__('თანამშრომლები')}}</p>
                                                <div  v-for="(el,index) in selectedCompany.employees" v-if="selectedCompany.employees.length && form.employees.length">
                                                   <div v-if="form.employees.includes(el.id)" class="flex space-between margin-top-14">
                                                       <div>
                                                            {{el.name}}
                                                       </div>

                                                       <div>
                                                           <button
                                                               type="button"
                                                               class="button button--link color-black text-decoration-none margin-left-16"
                                                               @click="removeEmployee(el.id)"
                                                           >
                                                               <delete-icon width="24" height="24"/>
                                                           </button>
                                                       </div>
                                                   </div>

                                                </div>
                                            </div>
                                            <div class="margin-minus-12 margin-top-16">
                                                <vue-collapsible-panel-group
                                                    base-color="#9DBF53"
                                                >
                                                    <vue-collapsible-panel
                                                        v-for="(_,index) in form.company_employee"
                                                        :key="index">
                                                        <template #title>
                                                            <p
                                                                class="color-black font-size-sm"
                                                                v-bind:class="{ 'validation_error': getDynamicErrors(index,'name','company_employee') || getDynamicErrors(index,'email','company_employee') }"
                                                            >
                                                        <span v-if="form.company_employee.length">
                                                            {{ form.company_employee[index].name }}
                                                        </span>
                                                            </p>
                                                        </template>
                                                        <template #content>
                                                            <div
                                                                class="form__group form__group--material margin-top-16">
                                                                <div class="form__group-addon" v-if="form.company_id">
                                                                    <button
                                                                        type="button"
                                                                        class="button button--link color-black text-decoration-none"
                                                                        @click="onMyColleagues"
                                                                    >
                                                                        <svg width="14" height="14" viewBox="0 0 14 14"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M7 0.25C7.41421 0.25 7.75 0.585786 7.75 1V6.25H13C13.4142 6.25 13.75 6.58579 13.75 7C13.75 7.41421 13.4142 7.75 13 7.75H7.75V13C7.75 13.4142 7.41421 13.75 7 13.75C6.58579 13.75 6.25 13.4142 6.25 13V7.75H1C0.585786 7.75 0.25 7.41421 0.25 7C0.25 6.58579 0.585786 6.25 1 6.25H6.25V1C6.25 0.585786 6.58579 0.25 7 0.25Z"
                                                                                  fill="#22282F"/>
                                                                        </svg>
                                                                    </button>
                                                                </div>
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
                                                            <div
                                                                class="form__group form__group--material margin-top-16">
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
                                                            <div
                                                                class="form__group form__group--material margin-top-16">
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
                                                            <div
                                                                class="form__group form__group--material margin-top-16">
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

                                    <c-button
                                        class="button button--primary button--shadow button--border width-full margin-top-24"
                                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        {{ __('რეგისტრაცია') }}
                                    </c-button>
                                </form>
                            </div>
                        </div>
                        <div class="width-452" v-else>
                            <h2>{{ __('ტრენინგზე აქტიური სესია არ მოიძებნა') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <my-companies @input="setCompanyId"/>
            <my-colleague @input="setEmployees"/>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import CashIcon from "@/Components/Web/Icons/Cash";
import UserIcon from "@/Components/Web/Icons/User";
import UsersIcon from "@/Components/Web/Icons/Users";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import Drawer from "@/Components/Web/Drawer/Drawer";
import emitter from "@/Plugins/bus";
import SelectObject from "@/Components/Web/Select/SelectObject";
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CButton from "@/CoreUi/components/Button";
import CInputLabel from "@/CoreUi/components/InputLabel";
import MyCompanies from "@/Components/Web/Popup/MyCompanies";
import MyColleague from "@/Components/Web/Popup/MyColleague";
import EditIcon from "@/Components/Web/Icons/Edit";
import DeleteIcon from "@/Components/Web/Icons/Delete";
import {
    VueCollapsiblePanelGroup,
    VueCollapsiblePanel,
} from '@dafcoe/vue-collapsible-panel'
import '@dafcoe/vue-collapsible-panel/dist/vue-collapsible-panel.css'

export default {
    components: {
        Button,
        Landing,
        Breadcrumb,
        CalendarIcon,
        CashIcon,
        UserIcon,
        UsersIcon,
        Drawer,
        SelectObject,
        CInputError,
        CInput,
        CButton,
        CInputLabel,
        VueCollapsiblePanelGroup,
        VueCollapsiblePanel,
        MyCompanies,
        MyColleague,
        EditIcon,
        DeleteIcon
    },
    props: {
        item: {
            type: Array
        },
        message: {
            type: String
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                mode: '',
                session_id: '',
                company_id: '',
                employees: [],
                terms: false,
                company: {
                    title: '',
                    identify_id: '',
                    address: '',
                    description: ''
                },
                company_employee: [{
                    name: '',
                    email: '',
                    role: '',
                    phone: ''
                }],
            }),
            mode: '',
            selectedTime: '',
            showHumans: false,
            sessionOptions: this.item.sessions.filter(el => el.can_register).map((el) => {
                return {
                    id: el.id,
                    label: `${el.start_time} ${el.start_time_hour}`
                };
            }),
            companyOptions: this.item.companies.map((el) => {
                return {
                    id: el.id,
                    label: el.title
                };
            }),
            employeeOptions: [],
            price: this.item.price,
            companyCount: 1,
            selectedCompany: null
        }
    },
    watch: {
        'form.session_id'(value) {
            let session = this.item.sessions.filter(e => e.id).find(el => el.id === this.form.session_id);
            if (session.price) {
                this.price = session.price;
            } else {
                this.price = this.item.price;
            }
        },
        'form.company_id'(value) {
            if (!value) {
                this.selectedCompany = null;
                return;
            }
            let company = this.item.companies.filter(e => e.id).find(el => el.id === value);
            if (company) {
                this.selectedCompany = company;
            }
            return;
        }
    },
    methods: {
        setMode(value) {
            this.mode = value
            this.form.mode = value;
        },
        submit() {
            this.form.post(this.route('trainings.register', this.item.slug), {
                onSuccess: () => setTimeout(() => {
                    location.reload()
                }, 1000),
            })
        },
        emptyCompanyId() {
            this.form.company_id = '';
            this.form.employees = [];
        },
        setCompanyId(value) {
            if (typeof value === 'number') {
                if (this.form.company_id !== value) {
                    this.form.company_id = value;
                    this.form.employees = [];
                }
            }
        },
        setEmployees(value) {
            if (value.length !== undefined) {
                this.form.employees = value;
            }
        },
        onNewHuman() {
            this.form.company_employee = [...this.form.company_employee, {
                name: '',
                email: '',
                role: '',
                phone: ''
            }]
        },

        onMyCompanies() {
            emitter.emit('showMyCompaniesPopup', {
                companies: this.companyOptions,
                company_id: this.form.company_id
            })
        },
        removeEmployee(id) {
            this.form.employees = this.form.employees.filter(function(item) {
                return item !== id
            })
        },
        onMyColleagues() {
            let company = this.item.companies.filter(e => e.id).find(el => el.id === this.form.company_id);
            let data = [];

            if (company.employees.length) {
                let session = this.item.sessions.filter(e => e.id).find(el => el.id === this.form.session_id);
                company.employees.forEach(el => {
                    // Check if employee already register
                    if (!session.attendees_employee.includes(el.id)) {
                        data.push({
                            id: el.id,
                            label: el.name
                        })
                    }
                })
                this.employeeOptions = data;
            }
            emitter.emit('showMyColleaguesPopup', {
                employeeOptions: data,
                employees: this.form.employees
            })
        },

        getSelectedValue(item) {
            if (item.selected) {
                this.form[`${item.model}`] = item.selected.id;
            }
        },
        getFirstSessionId() {
            if (this.sessionOptions) {
                return this.sessionOptions[0].id
            }
        },

        getDynamicErrors(index, value, module) {
            let key = `${module}.${index}.${value}`
            return this.form.errors[key] ?? '';
        },
        changeDynamic(index, key, module) {
            this.form[module][index][key] = event.target.value
        }
    }
}
</script>
