<template>
  <landing>
    <template v-slot:main>
      <breadcrumb/>
      <div class="content container">
        <div class="row margin-y-40">
          <div class="col-lg-3">
            <CustomSelect
                :options="['ტრენინგის მიმართულება', 'მარცხნივ', 'მარჯვნივ', 'ორივე']"
                :default="'ტრენინგის მიმართულება'"
                class="select"
            />
          </div>
        </div>
        <div class="row">
          <template v-for="item in 9">
            <div class="col-lg-4">
              <div class="card border-0 margin-bottom-42">
                <inertia-link :href="`/preview/news/show`" class="card__image" title="სათაური">
                  <img src="https://dummyimage.com/416x180/b3b3b3/fff.jpg" alt="სათაური">
                </inertia-link>

                <time class="card__date">20 აგვ 2021</time>

                <h4 class="card__title padding-top-14">როგორ ვებრძოლოთ დაავადებებს მცენარეებში</h4>
                <p class="card__text line-height-default">
                  ტრენინგის ფარგლებში გაეცნობით იმ
                  თანამედროვე ხერხებსა და ტენდენციებს
                  რაც დაგეხმარებათ უკედ ებრძოლოთ....
                </p>
              </div>
            </div>
          </template>
        </div>
      </div>
    </template>
  </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import CustomSelect from "@/Components/Web/Select/Select";

export default {
  components: {
    Landing,
    Breadcrumb,
    CustomSelect
  },
  props: {
    items: {
      type: Array
    },
  }
}
</script>
