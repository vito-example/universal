<template>
  <review-item
      v-for="review in reviews"
      :key="review.id"
      :review="review"
  >
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
        <h4 class="font-weight-600 padding-top-8">უბრალოდ საუკეთესო!</h4>
        <h6 class="color-dark-green font-weight-600 padding-top-12">
          {{ review.user.name }} {{ review.user.surname }}
        </h6>
      </div>
      <div
          class="color-dark-green opacity-60 font-weight-300 line-height-default padding-left-16"
          v-html="review.content"
      />
    </div>
  </review-item>
</template>

<script>
import StarRating from "./Rating/star-rating"
import ReviewItem from "./RreviewItem"
import {rateNames} from "@/Helpers/Rating"

export default {
  components: {
    StarRating,
    ReviewItem
  },

  props: {
    reviews: {
      type: Array
    }
  },

  computed: {
    rateName () {
      return rateNames
    }
  }
}
</script>