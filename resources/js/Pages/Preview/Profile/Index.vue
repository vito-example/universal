<template>
  <landing>
    <template v-slot:main>
      <div class="container">
        <h1 class="font-size-xl font-weight-600 margin-top-20">გამარჯობა, ირაკლი</h1>

        <div class="tab margin-top-10">
          <ul class="nav nav--horizontal nav--tabs">
            <li class="nav__item" :class="{ 'is-active': activeTab === 'personal' }">
              <a href="#" class="nav__link" title="პირადი ინფორმაცია" @click="setActiveTab('personal')">პირადი ინფორმაცია</a>
            </li>
            <li class="nav__item" :class="{ 'is-active': activeTab === 'companies' }">
              <a href="#" class="nav__link" title="ჩემი კომპანიები" @click="setActiveTab('companies')">ჩემი კომპანიები</a>
            </li>
            <li class="nav__item" :class="{ 'is-active': activeTab === 'colleagues' }">
              <a href="#" class="nav__link" title="ჩემი თანამშრომლები" @click="setActiveTab('colleagues')">ჩემი თანამშრომლები</a>
            </li>
            <li class="nav__item" :class="{ 'is-active': activeTab === 'security' }">
              <a href="#" class="nav__link" title="უსაფრთხოება" @click="setActiveTab('security')">უსაფრთხოება</a>
            </li>
          </ul>

          <div v-if="activeTab === 'personal'" class="tab__content is-active">
            <form class="form width-416">
              <div class="form__group form__group--material">
                <input type="text" class="form__element" id="firstName" value="ირაკლი" placeholder="თქვენი სახელი" autocomplete="off">
                <label class="form__label" for="firstName">სახელი</label>
              </div>

              <div class="form__group form__group--material margin-top-16">
                <input type="text" class="form__element" id="lastName" value="ქვათაძე" placeholder="გვარი" autocomplete="off">
                <label class="form__label" for="lastName">გვარი</label>
              </div>

              <div class="form__group form__group--material margin-top-16">
                <input type="text" class="form__element" id="email" value="kvatadze.me@gmail.com" placeholder="მეილი" autocomplete="off">
                <label class="form__label" for="email">მეილი</label>
              </div>

              <div class="form__group form__group--material margin-top-16">
                <input type="text" class="form__element" id="mobile" value="596 66 62 22" placeholder="ტელეფონის ნომერი" autocomplete="off">
                <label class="form__label" for="mobile">ტელეფონის ნომერი</label>
              </div>

              <button type="button" class="button button--primary button--shadow button--border width-full margin-top-24">მოაცემების შენახვა</button>
            </form>
          </div>

          <div v-if="activeTab === 'companies'" class="tab__content is-active">
            <div class="profile__list width-416">
              <div class="flex space-between margin-bottom-28">
                <div>
                  შპს აგრარული მეურნებოა
                </div>

                <div>
                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none"
                      @click="handleShowEditCompany"

                  >
                    <edit-icon width="24" height="24" />
                  </button>

                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none margin-left-16"
                      @click="handleShowDeletePopup"
                  >
                    <delete-icon width="24" height="24" />
                  </button>
                </div>
              </div>

              <div class="flex space-between margin-bottom-28">
                <div>
                  შპს აგრარული მეურნებოა
                </div>

                <div>
                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none"
                      @click="handleShowEditCompany"

                  >
                    <edit-icon width="24" height="24" />
                  </button>

                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none margin-left-16"
                      @click="handleShowDeletePopup"
                  >
                    <delete-icon width="24" height="24" />
                  </button>
                </div>
              </div>

              <div class="flex space-between margin-bottom-28">
                <div>
                  შპს აგრარული მეურნებოა
                </div>

                <div>
                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none"
                      @click="handleShowEditCompany"

                  >
                    <edit-icon width="24" height="24" />
                  </button>

                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none margin-left-16"
                      @click="handleShowDeletePopup"
                  >
                    <delete-icon width="24" height="24" />
                  </button>
                </div>
              </div>

              <hr>

              <button
                  type="button"
                  class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                  @click="handleShowNewCompany"
              >
                ახალი კომპანიის დამატება
              </button>

            </div>
          </div>

          <div v-if="activeTab === 'colleagues'" class="tab__content is-active">
            <div class="profile__list width-416">
              <div class="flex space-between margin-bottom-28">
                <div>
                  შპს აგრარული მეურნებოა
                </div>

                <div>
                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none"
                      @click="handleShowEditColleague"

                  >
                    <edit-icon width="24" height="24" />
                  </button>

                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none margin-left-16"
                      @click="handleShowDeletePopup"
                  >
                    <delete-icon width="24" height="24" />
                  </button>
                </div>
              </div>

              <div class="flex space-between margin-bottom-28">
                <div>
                  შპს აგრარული მეურნებოა
                </div>

                <div>
                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none"
                      @click="handleShowEditColleague"

                  >
                    <edit-icon width="24" height="24" />
                  </button>

                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none margin-left-16"
                      @click="handleShowDeletePopup"
                  >
                    <delete-icon width="24" height="24" />
                  </button>
                </div>
              </div>

              <div class="flex space-between margin-bottom-28">
                <div>
                  შპს აგრარული მეურნებოა
                </div>

                <div>
                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none"
                      @click="handleShowEditColleague"

                  >
                    <edit-icon width="24" height="24" />
                  </button>

                  <button
                      type="button"
                      class="button button--link color-black text-decoration-none margin-left-16"
                      @click="handleShowDeletePopup"
                  >
                    <delete-icon width="24" height="24" />
                  </button>
                </div>
              </div>

              <hr>

              <button
                  type="button"
                  class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                  @click="handleShowNewColleague"
              >
                ახალი თანამშრომლის დამატება
              </button>

            </div>
          </div>

          <div v-if="activeTab === 'security'" class="tab__content is-active">
            <form class="form width-416">
              <div class="form__group form__group--material">
                <input type="password" class="form__element" id="firstName" placeholder="არსებული პაროლი" autocomplete="off">
                <label class="form__label" for="firstName">არსებული პაროლი</label>
              </div>

              <div class="form__group form__group--material margin-top-16">
                  <input type="password" class="form__element" id="lastName" placeholder="პაროლი" autocomplete="off">
                <label class="form__label" for="lastName">პაროლი</label>
              </div>

              <div class="form__group form__group--material margin-top-16">
                <input type="password" class="form__element" id="email" placeholder="გაიმეორეთ პაროლი" autocomplete="off">
                <label class="form__label" for="email">გაიმეორეთ პაროლი</label>
              </div>

              <button type="button" class="button button--primary button--shadow button--border width-full margin-top-24">მოაცემების შენახვა</button>
            </form>
          </div>
        </div>
      </div>

      <new-company-popup />
      <edit-company-popup />
      <new-colleague-popup />
      <edit-colleague-popup />
      <delete-popup />
    </template>
  </landing>
</template>
<script>
import emitter from "@/Plugins/bus";
import Landing from "@/Layouts/Landing";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import Drawer from "@/Components/Web/Drawer/Drawer";
import EditIcon from "@/Components/Web/Icons/Edit";
import DeleteIcon from "@/Components/Web/Icons/Delete";
import DeletePopup from "@/Components/Web/Popup/Delete";
import NewCompanyPopup from "@/Components/Web/Popup/NewCompany";
import EditCompanyPopup from "@/Components/Web/Popup/EditCompany";
import NewColleaguePopup from "@/Components/Web/Popup/NewColleague";
import EditColleaguePopup from "@/Components/Web/Popup/EditColleague";

export default {
  components: {
    Landing,
    Breadcrumb,
    Drawer,
    EditIcon,
    DeleteIcon,
    NewCompanyPopup,
    EditCompanyPopup,
    DeletePopup,
    NewColleaguePopup,
    EditColleaguePopup
  },

  data () {
    return {
      activeTab: 'personal'
    }
  },

  methods: {
    setActiveTab (name) {
      this.activeTab = name
    },

    handleShowNewCompany () {
      emitter.emit('showNewCompanyPopup')
    },

    handleShowEditCompany () {
      emitter.emit('showEditCompanyPopup')
    },

    handleShowDeletePopup () {
      emitter.emit('showDeletePopup')
    },

    handleShowNewColleague () {
      emitter.emit('showNewColleaguePopup')
    },

    handleShowEditColleague () {
      emitter.emit('showEditColleaguePopup')
    },

    handleShowTrainer () {
      emitter.emit('showDrawer')
    }
  }
}
</script>
