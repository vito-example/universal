<template>
  <div class="review margin-top-48">
    <div class="review__body">
      <div class="review__left">
        <star-rating
            inactive-color="#D2D2D2"
            active-color="#0A2B12"
            :star-size="14"
            :show-rating="false"
            :read-only="true"
            :padding="10"
            v-model:rating="review.value"
        />
        <h4 class="font-weight-600 padding-top-8">{{ rateName }}</h4>
        <h6 class="color-dark-green font-weight-600 padding-top-12 text-uppercase">
          {{ review.user.name }} {{ review.user.surname }}
        </h6>
      </div>
      <div
          class="color-dark-green opacity-60 font-weight-300 line-height-default padding-left-16"
          v-html="review.content"
      />
    </div>
  </div>
</template>

<script>
import StarRating from "./Rating/star-rating"
import {rateNames} from "@/Helpers/Rating"

export default {
  components: {
    StarRating
  },

  props: {
    review: {
      type: Object
    }
  },

  computed: {
    rateValue () {
      return Number(this.review?.value)
    },

    rateName () {
      return rateNames[this.rateValue.toFixed(0)]
    }
  }
}
</script>