<template>
    <landing>
        <template v-slot:main>
            <div class="register container flex justify-center">
                <div class="width-416 margin-top-10">
                  <h2>რეგისტრაცია</h2>
                  <p class="padding-top-34">აირჩიეთ როგორ გსურთ რეგისტრაცია</p>

                  <div class="register__controls flex margin-top-24">
                    <button
                        class="button button--light is-outline font-size-xs width-198 padding-0 border-radius-10"
                        :class="{'border-color-middle-green-yellow': mode === 'personal', 'color-middle-green-yellow': mode === 'personal'}"
                        @click="setMode('personal')"
                    >
                      <div class="flex direction-column justify-center padding-y-20">
                        <div class="button__icon margin-bottom-10">
                          <user-icon width="30" height="30" />
                        </div>
                        ფიზიკური პირი
                      </div>
                    </button>

                    <button
                        class="button button--light is-outline font-size-xs width-198 margin-left-24 padding-0 border-radius-10"
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
                      <div
                          v-if="mode === 'company'"
                          class="font-size-md"
                      >
                        პირადი ინფორმაცია
                      </div>

                      <div class="form__group form__group--material margin-top-24">
                        <input type="text" class="form__element" id="firstName" placeholder="თქვენი სახელი*" autocomplete="off">
                        <label class="form__label" for="firstName">თქვენი სახელი*</label>
                      </div>

                      <div class="form__group form__group--material margin-top-16">
                        <input type="text" class="form__element" id="lastName" placeholder="გვარი*" autocomplete="off">
                        <label class="form__label" for="lastName">გვარი*</label>
                      </div>

                      <div class="form__group form__group--material margin-top-16">
                        <input type="text" class="form__element" id="email" placeholder="მეილი*" autocomplete="off">
                        <label class="form__label" for="email">მეილი*</label>
                      </div>

                      <div class="form__group form__group--material margin-top-16">
                        <input type="text" class="form__element" id="mobile" placeholder="ტელეფონის ნომერი" autocomplete="off">
                        <label class="form__label" for="mobile">ტელეფონის ნომერი</label>
                      </div>

                      <div class="form__group form__group--material margin-top-16">
                        <input type="password" class="form__element" id="password" placeholder="პაროლი" autocomplete="off">
                        <label class="form__label" for="password">პაროლი</label>
                      </div>

                      <div class="form__group form__group--material margin-top-16">
                        <input type="password" class="form__element" id="passwordConfirmation" placeholder="გაიმეორეთ პაროლი" autocomplete="off">
                        <label class="form__label" for="passwordConfirmation">გაიმეორეთ პაროლი</label>
                      </div>

                      <div
                          v-if="mode === 'company'"
                          class="margin-top-32"
                      >
                        <div class="font-size-md padding-bottom-8">კომპანიის ინფორმაცია</div>

                        <template
                            v-for="(company, index) in companyFields"
                            :key="index"
                        >
                          <div class="form__group form__group--material margin-top-16">
                            <input :type="company.type" class="form__element" :id="company.id" :placeholder="company.title" autocomplete="off">
                            <label class="form__label" :for="company.id">{{ company.title }}</label>
                          </div>
                        </template>

                        <button
                            type="button"
                            class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                            @click="onNewCompany"
                        >
                          სხვა კომპანიის დამატება
                        </button>

                        <div class="showable">
                          <button
                              type="button"
                              class="showable__title font-size-md margin-top-34 padding-bottom-8"
                              :class="{'is-active': showHumans}"
                              @click="onCollapseHumans"
                          >
                            თანამშრომლების ინფორმაცია
                          </button>

                          <div
                              v-if="showHumans"
                              class="showable__body"
                          >
                            <p class="color-black font-size-xs opacity-50 line-height-default padding-top-8">
                              თანამშრომლების ინფორმაცია შეგიძლიათ შეავსოთ როგორც ახლა.
                              ასევე შემდგომ თქვენი პირადი პროფილიდან
                            </p>

                            <template
                                v-for="(company, index) in humanFields"
                                :key="index"
                            >
                              <div class="form__group form__group--material margin-top-16">
                                <input :type="company.type" class="form__element" :id="company.id" :placeholder="company.title" autocomplete="off">
                                <label class="form__label" :for="company.id">{{ company.title }}</label>
                              </div>
                            </template>

                            <button
                                type="button"
                                class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                                @click="onNewHuman"
                            >
                              სხვა თანამშრომლის დამატება
                            </button>
                          </div>
                        </div>
                      </div>

                      <div class="form__group form__group--material margin-top-34">
                        <div class="checkbox">
                          <input type="checkbox" id="checkBox">
                          <label for="checkBox" class="font-size-2xs">
                            ვეთანხმები <a href="#" class="button button--link font-size-2xs font-weight-400">წესებს და პირობებს</a>
                          </label>
                        </div>
                      </div>

                      <button type="button" class="button button--primary button--shadow button--border width-full margin-top-24">რეგისტრაცია</button>
                    </form>
                  </div>
                </div>
            </div>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import UserIcon from "@/Components/Web/Icons/User";
import UsersIcon from "@/Components/Web/Icons/Users";
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button";

export default {
    components: {
      Button,
        Landing,
        UserIcon,
        UsersIcon
    },

    data () {
      return {
        mode: '',
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
