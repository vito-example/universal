<template>
  <div>
    <div class="rating flex items-center margin-top-32">
      <h3 class="color-dark-green font-size-md font-weight-600" v-if="reviews.data.length || reviews.can_review">{{__('შეფასება')}}</h3>

      <div class="rating__starts margin-left-24">
        <star-rating
            v-if="reviews.can_review"
            inactive-color="#D2D2D2"
            active-color="#0A2B12"
            :star-size="14"
            :show-rating="false"
            :padding="10"
            v-model:rating="form.value"
            @update:rating="setRating"
       />
      </div>
    </div>

    <form
        v-if="reviews.can_review"
        class="form margin-top-24"
        @submit.prevent="submit"
    >
      <div class="form__group form__group--material form__group--textarea">
        <textarea
            v-model="form.content"
            class="form__element"
            id="rateContent"
            placeholder="დაამატეთ თქვენი შეფასება..."
        />
        <label class="form__label" for="rateContent">დაამატეთ თქვენი შეფასება...</label>
      </div>

      <div class="flex space-between items-center margin-top-24">
          <div class="flex items-center">
              <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2422 2.25C5.68584 2.25 1.99219 5.94365 1.99219 10.5C1.99219 15.0563 5.68584 18.75 10.2422 18.75C14.7985 18.75 18.4922 15.0563 18.4922 10.5C18.4922 5.94365 14.7985 2.25 10.2422 2.25ZM0.492188 10.5C0.492188 5.11522 4.85741 0.75 10.2422 0.75C15.627 0.75 19.9922 5.11522 19.9922 10.5C19.9922 15.8848 15.627 20.25 10.2422 20.25C4.85741 20.25 0.492188 15.8848 0.492188 10.5ZM10.2422 5.75C10.6564 5.75 10.9922 6.08579 10.9922 6.5V11.5C10.9922 11.9142 10.6564 12.25 10.2422 12.25C9.82797 12.25 9.49219 11.9142 9.49219 11.5V6.5C9.49219 6.08579 9.82797 5.75 10.2422 5.75ZM10.2422 15.5C10.7945 15.5 11.2422 15.0523 11.2422 14.5C11.2422 13.9477 10.7945 13.5 10.2422 13.5C9.6899 13.5 9.24219 13.9477 9.24219 14.5C9.24219 15.0523 9.6899 15.5 10.2422 15.5Z" fill="#22282F"/>
              </svg>

              <p class="color-black font-size-xs font-weight-400 padding-left-8">
                  თქვენი შეფასება დაემატება მოდერაციის გავლის შემდეგ
              </p>
          </div>

        <button
            class="button button--primary button--shadow button--border"
            :class="{ 'is-disabled': !form.content || !form.value }"
            :disabled="!form.content || !form.value"
        >
          შეფასების დამატება
        </button>
      </div>
    </form>

    <div class="card margin-top-48" v-if="success">
      <div class="card__body">
        <p class="color-middle-green-yellow font-weight-500 text-center">{{ __('შეფასება წარმატებით დაემატა.') }}</p>
      </div>
    </div>

    <review-content :reviews="reviews.data" />
  </div>
</template>

<script>
import StarRating from './Rating/star-rating'
import ReviewContent from './ReviewContent'
import emitter from "@/Plugins/bus";

export default {
  props: {
    event: {
      type: Object
    },
    reviews: {
      type: Array
    }
  },

  components: {
    StarRating,
    ReviewContent
  },

  data() {
    return {
      form: this.$inertia.form({
        value: 0,
        content: ''
      }),
      success: false
    };
  },

  methods: {
    setRating(rating) {
      this.rating = rating
    },

    submit() {
      if (!this.isAuth()) {
        emitter.emit('showLoginPopup')

        return false
      }

      this.form.transform((data) => ({
        ...data,
        event_id: this.event.id,
      })).post(this.route('review.store'), {
        preserveScroll: true,
        onSuccess: () => {
          this.form.value = 0
          this.form.content = ''
          this.success = true
        }
      })
    },
  }
}
</script>