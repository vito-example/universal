<template>
    <landing>
        <template v-slot:main>
            <div class="trainings-single container margin-top-48">
              <div class="trainings-single__content">
                <div class="trainings-single__left">
                  <div class="trainings-single__labels">
                    <div class="flex space-between margin-bottom-16">
                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        <calendar-icon width="16" height="16" /> <span class="padding-left-6">20 აგვ 2021</span>
                      </div>

                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        10:00
                      </div>
                    </div>

                    <div class="flex space-between margin-bottom-16">
                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        <calendar-icon width="16" height="16" /> <span class="padding-left-6">20 აგვ 2021</span>
                      </div>

                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        10:00
                      </div>
                    </div>

                    <div class="flex space-between margin-bottom-16">
                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        <calendar-icon width="16" height="16" /> <span class="padding-left-6">20 აგვ 2021</span>
                      </div>

                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        10:00
                      </div>
                    </div>

                    <div class="flex space-between margin-bottom-16">
                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        <calendar-icon width="16" height="16" /> <span class="padding-left-6">20 აგვ 2021</span>
                      </div>

                      <div class="label label--light-outline inline-flex items-center padding-y-8">
                        10:00
                      </div>
                    </div>

                    <div class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8">
                      ფასი: 1000 ₾
                    </div>

                    <div class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8">
                      ჩატარების ადგილი: თბილისი
                    </div>

                    <div class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8">
                      საკონტაქტო ნომერი 032 2 68 00 90
                    </div>
                  </div>
                </div>

                <div class="trainings-single__right padding-left-134">
                  <div class="width-452">
                    <h2>რეგისტრაცია ტრენინგზე</h2>
                    <p class="padding-top-34">აირჩიეთ როგორ გსურთ რეგისტრაცია</p>

                    <div class="register__controls flex margin-top-24">
                      <button
                          class="button button--light is-outline font-size-xs width-214 padding-0 border-radius-10"
                          :class="{'border-color-middle-green-yellow': mode === 'personal', 'color-middle-green-yellow': mode === 'personal'}"
                          @click="setMode('personal')"
                      >
                        <div class="flex direction-column justify-center padding-y-20">
                          <div class="button__icon margin-bottom-10">
                            <user-icon width="25" height="30" />
                          </div>
                            ჩემთვის
                        </div>
                      </button>

                      <button
                          class="button button--light is-outline font-size-xs width-214 margin-left-24 padding-0 border-radius-10"
                          :class="{'border-color-middle-green-yellow': mode === 'company', 'color-middle-green-yellow': mode === 'company'}"
                          @click="setMode('company')"
                      >
                        <div class="flex direction-column justify-center padding-y-20">
                          <div class="button__icon margin-bottom-10">
                            <users-icon width="30" height="30" />
                          </div>
                          კომპანია
                        </div>
                      </button>
                    </div>

                    <div
                        v-if="mode"
                        class="register__content margin-top-26"
                    >
                      <form
                          class="form width-full"
                      >
                        <template v-if="mode === 'personal'">
                          <CustomSelect
                              :options="['20 აგვ 2021; 10:00 სთ', '20 აგვ 2021; 14:00 სთ', '20 აგვ 2021; 18:00 სთ']"
                              :default="'აირჩიეთ ტრენინგის სასურველი დრო'"
                              class="select"
                              @input="getSelectedValue"
                          />
                        </template>

                        <div
                            v-if="mode === 'company'"
                            class="margin-top-16"
                        >

                          <CustomSelect
                              :options="['Apple', 'Google', 'Microsoft']"
                              :default="'აირჩიეთ კომპანია'"
                              class="select"
                          />

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field1" placeholder="კომპანიის საქმინობის სფერო" autocomplete="off">
                            <label class="form__label" for="field1">კომპანიის საქმინობის სფერო</label>
                          </div>

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field2" placeholder="კომპანიის საქმინობის სფერო" autocomplete="off">
                            <label class="form__label" for="field2">კომპანიის საქმინობის სფერო</label>
                          </div>

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field3" placeholder="თანამშრომლის სახელი" autocomplete="off">
                            <label class="form__label" for="field3">თანამშრომლის სახელი</label>
                          </div>

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field4" placeholder="თანამშრომლის გვარი" autocomplete="off">
                            <label class="form__label" for="field4">თანამშრომლის გვარი</label>
                          </div>

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field5" placeholder="როლი კომპანიაში" autocomplete="off">
                            <label class="form__label" for="field5">როლი კომპანიაში</label>
                          </div>

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field6" placeholder="მეილი" autocomplete="off">
                            <label class="form__label" for="field6">მეილი</label>
                          </div>

                          <div class="form__group form__group--material margin-top-24">
                            <input type="text" class="form__element" id="field7" placeholder="ტელეფონის ნომერი" autocomplete="off">
                            <label class="form__label" for="field7">ტელეფონის ნომერი</label>
                          </div>

                          <div class="form__group form__group--material margin-top-34">
                            <div class="checkbox">
                              <input type="checkbox" id="checkBox">
                              <label for="checkBox" class="font-size-2xs">
                                ვეთანხმები <a href="#" class="button button--link font-size-2xs font-weight-400">წესებს და პირობებს</a>
                              </label>
                            </div>
                          </div>

                          <div class="form__group form__group--material margin-top-6">
                            <div class="checkbox">
                              <input type="checkbox" id="checkBox2">
                              <label for="checkBox2" class="font-size-2xs">
                                კომპანიის მონაცემების პროფილში შენახვა
                              </label>
                            </div>
                          </div>
                        </div>

                        <button type="button" class="button button--primary button--shadow button--border width-full margin-top-24">რეგისტრაცია</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
import CustomSelect from "@/Components/Web/Select/Select";
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button";

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
        CustomSelect
    },

    data () {
      return {
        mode: '',
        selectedTime: '',
        showHumans: false,
        companyFields: [
          {
            title: 'კომპანიის სახელი',
            type: 'text',
            id: 'companyName'
          },
          {
            title: 'კომპანიის მუშაობის სფერო',
            type: 'text',
            id: 'companySummary'
          }
        ],
        humanFields: [
          {
            title: 'სახელი',
            type: 'text',
            id: 'humanName'
          },
          {
            title: 'გვარი',
            type: 'text',
            id: 'humanLastName'
          },
          {
            title: 'როლი კომპანიაში',
            type: 'text',
            id: 'humanRole'
          },
          {
            title: 'მეილი',
            type: 'email',
            id: 'humanEmail'
          },
          {
            title: 'ტელეფონის ნომერი',
            type: 'text',
            id: 'humanTelephone'
          }
        ]
      }
    },

    methods: {
      setMode (value) {
        this.mode = value
      },

      getSelectedValue (value) {
        this.selectedTime = value
      },

      onNewCompany () {
        this.companyFields.push(
            {
              title: 'კომპანიის სახელი',
              type: 'text',
              id: 'companyName'
            },
            {
              title: 'კომპანიის მუშაობის სფერო',
              type: 'text',
              id: 'companySummary'
            }
        )
      },

      onNewHuman () {
        this.humanFields.push(
            {
              title: 'სახელი',
              type: 'text',
              id: 'humanName'
            },
            {
              title: 'გვარი',
              type: 'text',
              id: 'humanLastName'
            },
            {
              title: 'როლი კომპანიაში',
              type: 'text',
              id: 'humanRole'
            },
            {
              title: 'მეილი',
              type: 'email',
              id: 'humanEmail'
            },
            {
              title: 'ტელეფონის ნომერი',
              type: 'text',
              id: 'humanTelephone'
            }
        )
      },

      onCollapseHumans () {
        this.showHumans = !this.showHumans
      }
    }
}
</script>
