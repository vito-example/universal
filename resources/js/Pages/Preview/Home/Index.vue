<template>
  <landing class="home">
    <template v-slot:main>
      <div class="content container margin-top-50">
        <div class="hero flex space-between">
          <div class="hero__content padding-right-80">
            <h2 class="color-dark-green font-size-xxl font-weight-600 line-height-default">ტრენინგები თქვენი აგრო ბიზნესის განვითარებისთვის</h2>
            <p class="color-dark-green line-height-default padding-top-30">
              შეარჩიე და გაიარე ტრენინგი ჩვენი მაღალი პროფესიონალი<br>
              ტრენერების დახმარებით და განავითარე შენი აგრო ბიზნესი<br>
              ისე როგორც არასდროს!
            </p>

            <inertia-link :href="route('preview.trainings')" class="button button--primary button--shadow button--border margin-top-38">
              ტრენინგები
            </inertia-link>
          </div>

          <div class="hero__image">
            <img src="/images/hero-image.svg" alt="#">
          </div>
        </div>

        <div class="home__section margin-top-50">
          <h4 class="color-dim-gray font-weight-400 text-center">500+ კომპანია რომელიც გვენდობა!</h4>

          <div class="flex space-between padding-top-40 padding-x-80">
            <a href="#">
              <img src="https://dummyimage.com/186x52/fff/000.jpg" class="border-radius-10" alt="">
            </a>

            <a href="#">
              <img src="https://dummyimage.com/186x52/fff/000.jpg" class="border-radius-10" alt="">
            </a>

            <a href="#">
              <img src="https://dummyimage.com/186x52/fff/000.jpg" class="border-radius-10" alt="">
            </a>

            <a href="#">
              <img src="https://dummyimage.com/186x52/fff/000.jpg" class="border-radius-10" alt="">
            </a>

            <a href="#">
              <img src="https://dummyimage.com/186x52/fff/000.jpg" class="border-radius-10" alt="">
            </a>
          </div>
        </div>

        <div class="home__section margin-top-80">
          <div class="flex space-between items-center">
            <h2 class="font-weight-600">ტრენინგები</h2>

            <inertia-link :href="route('preview.trainings')" class="button button--link color-hunter-green text-decoration-none">
              ყველა ტრენინგი
            </inertia-link>
          </div>

          <div class="row margin-top-48">
            <template v-for="item in 3" :key="item">
              <div class="col-lg-4">
                <div class="card margin-bottom-44">
                  <div class="card__body">
                    <inertia-link :href="`/preview/trainings/show`" class="card__image" title="სათაური">
                      <img src="https://dummyimage.com/352x180/b3b3b3/fff.jpg" alt="სათაური">
                    </inertia-link>

                    <h4 class="card__title">როგორ ვებრძოლოთ დაავადებებს მცენარეებში</h4>
                    <p class="card__text font-weight-400 line-height-default">
                      ტრენინგის ფარგლებში გაეცნობით იმ
                      თანამედროვე ხერხებსა და ტენდენციებს
                      რაც დაგეხმარებათ უკედ ებრძოლოთ....
                    </p>

                    <div class="flex margin-top-29">
                      <div class="label label--light-outline flex items-center">
                        <div class="label__icon line-height-0 padding-right-8">
                          <calendar-icon width="16" height="16" />
                        </div>

                        20 აგვ 2021
                      </div>
                      <div class="label label--light-outline flex items-center margin-left-12">
                        <div class="label__icon line-height-0 padding-right-8">
                          <cash-icon width="16" height="12"/>
                        </div>

                        ფასი: 1000 ₾
                      </div>
                    </div>

                    <a href="#" class="color-black text-decoration-none block margin-top-29">რეგისტრაცია</a>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>

        <div class="home__section margin-top-70">
          <div class="flex space-between items-center">
            <h2 class="font-weight-600">ონლაინ ტრენინგები</h2>

            <inertia-link :href="route('preview.online')" class="button button--link color-hunter-green text-decoration-none">
              ყველა ტრენინგი
            </inertia-link>
          </div>

          <div class="row margin-top-48">
            <template v-for="item in 3" :key="item">
              <div class="col-lg-4">
                <div class="card margin-bottom-44">
                  <div class="card__body">
                    <inertia-link :href="`/preview/trainings/show`" class="card__image" title="სათაური">
                      <img src="https://dummyimage.com/352x180/b3b3b3/fff.jpg" alt="სათაური">
                    </inertia-link>

                    <h4 class="card__title">როგორ ვებრძოლოთ დაავადებებს მცენარეებში</h4>
                    <p class="card__text font-weight-400 line-height-default">
                      ტრენინგის ფარგლებში გაეცნობით იმ
                      თანამედროვე ხერხებსა და ტენდენციებს
                      რაც დაგეხმარებათ უკედ ებრძოლოთ....
                    </p>

                    <div class="flex margin-top-29">
                      <div class="label label--light-outline flex items-center">
                        <div class="label__icon line-height-0 padding-right-8">
                          <calendar-icon width="16" height="16" />
                        </div>

                        20 აგვ 2021
                      </div>
                      <div class="label label--light-outline flex items-center margin-left-12">
                        <div class="label__icon line-height-0 padding-right-8">
                          <cash-icon width="16" height="12"/>
                        </div>

                        ფასი: 1000 ₾
                      </div>
                    </div>

                    <a href="#" class="color-black text-decoration-none block margin-top-29">რეგისტრაცია</a>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>

        <div class="home__section margin-top-70">
          <div class="row">
            <div class="col-lg-6">
              <h2 class="color-dark-green font-size-xl font-weight-600 line-height-default padding-right-30">ბოლო სიახლეები და საინტერესო ინფორმაციები</h2>
              <p class="color-dark-green line-height-default padding-top-30">
                შეარჩიე და გაიარე ტრენინგი ჩვენი მაღალი პროფესიონალი<br>
                ტრენერების დახმარებით და განავითარე შენი აგრო ბიზნესი<br>
                ისე როგორც არასდროს!
              </p>

              <inertia-link :href="route('preview.news')" class="button button--primary button--shadow button--border margin-top-38">
                ყველა სიახლე
              </inertia-link>
            </div>

            <div class="col-lg-6">
              <div class="row">
                <template v-for="item in 2">
                  <div class="col-lg-6">
                    <div class="card border-0">
                      <inertia-link :href="`/preview/news/show`" class="card__image" title="სათაური">
                        <img src="https://dummyimage.com/306x180/b3b3b3/fff.jpg" alt="სათაური">
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
          </div>
        </div>

        <div class="home__section margin-top-100">
          <div class="row">
            <div class="col-lg-6">
              <img src="https://dummyimage.com/552x420/b3b3b3/fff.jpg" alt="Name" class="margin-top-6 border-radius-10">
            </div>

            <div class="col-lg-6">
              <h2 class="color-dark-green font-weight-600 line-height-default">ჩვენ შესახებ</h2>
              <p class="color-dark-green line-height-default padding-top-20">
                <strong>„აგრარიუმი“ არის სოფლის მეურნეობის მიმართულების სასწავლო ტრენინგ-
                  ცენტრი,</strong> რომელიც ჩამოყალიბდა შ.პ.ს <strong>„ნობლექსი“-ს</strong> ბაზაზე 2021წელს და
                ახორციელებს პრაქტიკულ ტრენინგებს აგრონომიის მიმართულებით.
                <br><br>
                აგრარიუმის შექმნის იდეაა, სოფლის მეურნეობის მიმართულებით მომუშავე
                <strong>კომპანიებისა და ფერმერებისათვის პრაქტიკული ტრენინგების შეთავაზება და
                  არსებული გამოცდილების გაზიარება.</strong>
                <br><br>
                თითოეული ტრენინგის თემატიკა, შემუშავებულია <strong>კომპანიებისა და
                ფერმერების აქტუალურ პრობლემებზე დაყრდნობით.</strong>
              </p>
            </div>
          </div>
        </div>

        <div class="home__section margin-top-100">
          <div class="row">
            <div class="col-lg-3">
              <h2 class="color-dark-green font-weight-600 line-height-default">გაიცანით ჩვენი ტრენერები</h2>
              <p class="color-dark-green line-height-default padding-top-30">
                ჩვენი მაღალი პროფესიონალური<br>
                ტრენერები მრავალწლიანი<br>
                გამოცდილებით მზად არიან<br>
                დაგეხმაროთ თქვენი აგრო ბიზნესის<br>
                განვითარებაში და მოგაწოდონ<br>
                ყველაზე საჭირო ცოდნა<br>
                ტრენინგების მეშვეობით<br>
              </p>

              <inertia-link :href="route('preview.trainers')" class="button button--link color-dark-green margin-top-38">
                ყველა ტრენერი
              </inertia-link>
            </div>

            <template v-for="item in 3">
              <div class="col-lg-3">
                <div class="person">
                  <a class="person__image cursor-pointer" title="Name">
                    <img src="https://dummyimage.com/306x400/b3b3b3/fff.jpg" alt="Name">
                    <div class="person__overlay">
                      <div class="person__info">
                        <h5 class="person__title">ირაკლი ქვათაძე</h5>
                        <p class="person__text line-height-default">
                          საქართველოს ტრენერების ასოციაციის უფროსი და მრავალი წლიანი გამოცილების მქონდე ირაკლი ქვათაძე
                          თქვენს სამსახურში
                        </p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </template>
          </div>
        </div>

        <div class="home__section margin-top-100">
          <h2 class="font-weight-600 text-center">სტატისტიკა</h2>

          <div class="flex space-between margin-top-44">
            <div class="text-center">
              <div class="font-size-xxl font-weight-600">200+</div>
              <div class="font-weight-300 padding-top-24">ჩატარებული ტრენინგი</div>
            </div>

            <div class="text-center">
              <div class="font-size-xxl font-weight-600">2500+</div>
              <div class="font-weight-300 padding-top-24">დატრენინგებული ადამინი</div>
            </div>

            <div class="text-center">
              <div class="font-size-xxl font-weight-600">30</div>
              <div class="font-weight-300 padding-top-24">ტრენერი</div>
            </div>

            <div class="text-center">
              <div class="font-size-xxl font-weight-600">20</div>
              <div class="font-weight-300 padding-top-24">ტრენინგების მიმართულება</div>
            </div>
          </div>
        </div>

        <div class="home__section margin-top-120">
          <h2 class="color-dark-green font-weight-600 text-center">მომხმარებლები ჩვენს შესახებ</h2>
          <p class="color-dark-green opacity-60 font-weight-300 text-center line-height-default padding-top-28">
            ჩვენ გვყავს 2000+ წარმატებული მომხმარებელი რომლებიც<br>
            ბედნიერები ავითარებენ მათ აგრო ბიზნესებს ჩვენი ტრენინგების შემდეგ
          </p>

          <div class="row margin-top-48">
            <div class="col-lg-3">
              <img src="/images/stars.svg" alt="#">
              <h4 class="font-weight-600 padding-top-8">უბრალოდ საუკეთესო!</h4>
              <h6 class="color-dark-green font-weight-600 padding-top-12">ირაკლი ქვათაძე</h6>

              <p class="color-dark-green opacity-60 font-weight-300 line-height-default border-bottom-1 padding-top-22 padding-bottom-26">
                ტრენინგებით უზომოდ კმაყოფილი
                ვარ! ჩემი ცოდნა ერთი ათად
                გაიზარდა!
              </p>

              <button class="button button--link font-size-xs color-dark-green flex items-center margin-y-16">
                <div class="button__icon line-height-0 padding-right-10">
                  <favourite-icon width="16" height="20" />
                </div>

                მცენარეების დაცვის და მოვლის ტრენინგი
              </button>
            </div>

            <div class="col-lg-3">
              <img src="/images/stars.svg" alt="#">
              <h4 class="font-weight-600 padding-top-8">უბრალოდ საუკეთესო!</h4>
              <h6 class="color-dark-green font-weight-600 padding-top-12">ირაკლი ქვათაძე</h6>

              <p class="color-dark-green opacity-60 font-weight-300 line-height-default border-bottom-1 padding-top-22 padding-bottom-26">
                ტრენინგებით უზომოდ კმაყოფილი
                ვარ! ჩემი ცოდნა ერთი ათად
                გაიზარდა!
              </p>

              <button class="button button--link font-size-xs color-dark-green flex items-center margin-y-16">
                <div class="button__icon line-height-0 padding-right-10">
                  <favourite-icon width="16" height="20" />
                </div>

                მცენარეების დაცვის და მოვლის ტრენინგი
              </button>
            </div>

            <div class="col-lg-3">
              <img src="/images/stars.svg" alt="#">
              <h4 class="font-weight-600 padding-top-8">უბრალოდ საუკეთესო!</h4>
              <h6 class="color-dark-green font-weight-600 padding-top-12">ირაკლი ქვათაძე</h6>

              <p class="color-dark-green opacity-60 font-weight-300 line-height-default border-bottom-1 padding-top-22 padding-bottom-26">
                ტრენინგებით უზომოდ კმაყოფილი
                ვარ! ჩემი ცოდნა ერთი ათად
                გაიზარდა!
              </p>

              <button class="button button--link font-size-xs color-dark-green flex items-center margin-y-16">
                <div class="button__icon line-height-0 padding-right-10">
                  <favourite-icon width="16" height="20" />
                </div>

                მცენარეების დაცვის და მოვლის ტრენინგი
              </button>
            </div>

            <div class="col-lg-3">
              <img src="/images/stars.svg" alt="#">
              <h4 class="font-weight-600 padding-top-8">უბრალოდ საუკეთესო!</h4>
              <h6 class="color-dark-green font-weight-600 padding-top-12">ირაკლი ქვათაძე</h6>

              <p class="color-dark-green opacity-60 font-weight-300 line-height-default border-bottom-1 padding-top-22 padding-bottom-26">
                ტრენინგებით უზომოდ კმაყოფილი
                ვარ! ჩემი ცოდნა ერთი ათად
                გაიზარდა!
              </p>

              <button class="button button--link font-size-xs color-dark-green flex items-center margin-y-16">
                <div class="button__icon line-height-0 padding-right-10">
                  <favourite-icon width="16" height="20" />
                </div>

                მცენარეების დაცვის და მოვლის ტრენინგი
              </button>
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
import FavouriteIcon from "@/Components/Web/Icons/Favourite";

export default {
  components: {
    Landing,
    CalendarIcon,
    CashIcon,
    FavouriteIcon
  }
}
</script>
