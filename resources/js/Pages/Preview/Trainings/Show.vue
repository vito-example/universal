<template>
    <landing>
        <template v-slot:main>
            <breadcrumb />

            <div class="trainings-single container margin-top-48">
              <img src="https://dummyimage.com/1296x390/b3b3b3/fff.jpg" class="border-radius-10" alt="">

              <div class="trainings-single__content">
                <div class="trainings-single__left margin-top-40">
                  <a href="#" class="button button--primary button--shadow button--border text-center width-full">რეგისტრაცია</a>

                  <hr>

                  <div class="trainings-single__labels">
                    <div class="label label--light-outline inline-flex items-center padding-y-8">
                      20 აგვ 2021
                    </div>

                    <div class="label label--light-outline inline-flex items-center margin-top-10 padding-y-8">
                      ფასი: 1000 ₾
                    </div>

                    <div class="label label--light-outline inline-flex items-center margin-top-10 padding-y-8">
                      ჩატარების ადგილი: თბილისი
                    </div>

                    <div class="label label--light-outline inline-flex items-center margin-top-10 padding-y-8">
                      საკონტაქტო ნომერი 032 2 68 00 90
                    </div>
                  </div>

                  <hr>

                  <button
                      type="button"
                      class="button button--link color-fulvous font-size-sm text-decoration-none block"
                      @click="handleShowProgram"
                  >
                    იხილეთ პროგრამა
                  </button>
                </div>

                <div class="trainings-single__right padding-left-134">
                  <h2 class="font-weight-600 margin-top-40">რით ვებრძოლოთ დაავადებებს მცენარეებში</h2>

                  <div class="font-size-sm font-weight-300 line-height-default margin-top-24">
                    ომხმარებელთა კომფორტისთვის „აგროსფერო“-ში სასოფლო-სამეურნეო პროდუქციის სრული სპექტრი გვაქვს წარმოდგენილი, რაც მათ საშუალებას აძლევს ყველაფერი ერთიან სივრცეში შეიძინონ, დაზოგონ დრო, ენერგია და მიიღონ მაღალკვალიფიციური კონსულტაცია, რაც საბოლოო ჯამში საუკეთესო შედეგს განაპირობებს. ჩვენი პროდუქციის ასორტიმენტი მოიცავს: მცენარეთა დაცვის საშუალებებს, მინერალურ სასუქებს, აგროტექნიკას, სათესლე მასალას, წვეთოვანი მორწყვის სისტემებს, სამუშაო იარაღებსა და ფერმერისთვის საჭირო სხვა პროდუქციას, ასევე დანადგარებისა და დამხმარე მასალების ფართო სპექტრს ალკოჰოლური და უალკოჰოლო სასმელების წარმოებისთვის.
                    <br><br>
                    საქართველოში წარმოვადგენთ მსოფლიოს ლიდერ 20-ზე მეტ კომპანიას სხვადასხვა მიმართულებით: მცენარეთა დაცვის საშუალებები - Bayer AG, მინერალური სასუქები - Yara, სასოფლო სამეურნეო ტექნიკა - Claas, სათესლე მასალა - Rijk Zwaan, Nunhems, წვეთოვანი მორწყვის სისტემები - Irritec, ფილტრაციის სისტემები - Pall, მუხის კასრები და დამხმარე მასალები - Seguin Moreau და სხვა.
                  </div>

                  <img src="https://dummyimage.com/966x440/b3b3b3/fff.jpg" class="margin-top-40 border-radius-10" alt="">

                  <div class="font-size-sm font-weight-300 line-height-default margin-top-40">
                    ომხმარებელთა კომფორტისთვის „აგროსფერო“-ში სასოფლო-სამეურნეო პროდუქციის სრული სპექტრი გვაქვს წარმოდგენილი, რაც მათ საშუალებას აძლევს ყველაფერი ერთიან სივრცეში შეიძინონ, დაზოგონ დრო, ენერგია და მიიღონ მაღალკვალიფიციური კონსულტაცია, რაც საბოლოო ჯამში საუკეთესო შედეგს განაპირობებს. ჩვენი პროდუქციის ასორტიმენტი მოიცავს: მცენარეთა დაცვის საშუალებებს, მინერალურ სასუქებს, აგროტექნიკას, სათესლე მასალას, წვეთოვანი მორწყვის სისტემებს, სამუშაო იარაღებსა და ფერმერისთვის საჭირო სხვა პროდუქციას, ასევე დანადგარებისა და დამხმარე მასალების ფართო სპექტრს ალკოჰოლური და უალკოჰოლო სასმელების წარმოებისთვის.
                    <br><br>
                    საქართველოში წარმოვადგენთ მსოფლიოს ლიდერ 20-ზე მეტ კომპანიას სხვადასხვა მიმართულებით: მცენარეთა დაცვის საშუალებები - Bayer AG, მინერალური სასუქები - Yara, სასოფლო სამეურნეო ტექნიკა - Claas, სათესლე მასალა - Rijk Zwaan, Nunhems, წვეთოვანი მორწყვის სისტემები - Irritec, ფილტრაციის სისტემები - Pall, მუხის კასრები და დამხმარე მასალები - Seguin Moreau და სხვა.
                  </div>

                  <div class="margin-top-40">
                    <div class="row">
                      <div class="col-lg-6">
                        <img src="https://dummyimage.com/471x212/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                      </div>

                      <div class="col-lg-6">
                        <img src="https://dummyimage.com/471x212/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                      </div>
                    </div>
                  </div>

                  <div class="font-size-sm font-weight-300 line-height-default margin-top-40">
                    ომხმარებელთა კომფორტისთვის „აგროსფერო“-ში სასოფლო-სამეურნეო პროდუქციის სრული სპექტრი გვაქვს წარმოდგენილი, რაც მათ საშუალებას აძლევს ყველაფერი ერთიან სივრცეში შეიძინონ, დაზოგონ დრო, ენერგია და მიიღონ მაღალკვალიფიციური კონსულტაცია, რაც საბოლოო ჯამში საუკეთესო შედეგს განაპირობებს. ჩვენი პროდუქციის ასორტიმენტი მოიცავს: მცენარეთა დაცვის საშუალებებს, მინერალურ სასუქებს, აგროტექნიკას, სათესლე მასალას, წვეთოვანი მორწყვის სისტემებს, სამუშაო იარაღებსა და ფერმერისთვის საჭირო სხვა პროდუქციას, ასევე დანადგარებისა და დამხმარე მასალების ფართო სპექტრს ალკოჰოლური და უალკოჰოლო სასმელების წარმოებისთვის.
                    <br><br>
                    საქართველოში წარმოვადგენთ მსოფლიოს ლიდერ 20-ზე მეტ კომპანიას სხვადასხვა მიმართულებით: მცენარეთა დაცვის საშუალებები - Bayer AG, მინერალური სასუქები - Yara, სასოფლო სამეურნეო ტექნიკა - Claas, სათესლე მასალა - Rijk Zwaan, Nunhems, წვეთოვანი მორწყვის სისტემები - Irritec, ფილტრაციის სისტემები - Pall, მუხის კასრები და დამხმარე მასალები - Seguin Moreau და სხვა.
                  </div>

                  <h4 class="font-weight-600 margin-top-48">ფოტო გალერეა</h4>

                  <div class="margin-top-32">
                    <div class="row">
                      <div class="col-lg-3">
                        <img src="https://dummyimage.com/224x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                      </div>

                      <div class="col-lg-3">
                        <img src="https://dummyimage.com/224x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                      </div>

                      <div class="col-lg-3">
                        <img src="https://dummyimage.com/224x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                      </div>

                      <div class="col-lg-3">
                        <img src="https://dummyimage.com/224x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                      </div>
                    </div>
                  </div>

                  <h4 class="font-weight-600 margin-top-48">ტრენერი</h4>

                  <div class="row margin-top-32">
                    <div class="col-lg-6">
                      <img src="https://dummyimage.com/470x250/b3b3b3/fff.jpg" class="border-radius-10" alt="">
                    </div>

                    <div class="col-lg-6">
                      <h4 class="color-dark-green font-size-sm font-weight-600">ირაკლი ქვათაძე</h4>

                      <p class="color-dark-green opacity-60 font-size-sm font-weight-400 line-height-default margin-top-16">
                        ირაკლი, თავისი კარიერის განმავლობაში ძალიან აქტიურად იღებდა და იღებს
                        მონაწილეობას მექანიზაციის მიმართულებით ტრენინგებში, სამიტებზე,
                        კონფერენციებსა და ა.შ მათ შორისაა:
                        <br><br>
                        <strong>„SYSTEMTECHNIK - CLAAS Global Seles GmbH“, ჰარზევინკელი, გერმანია</strong>
                      </p>

                      <a class="button button--link color-dark-green margin-top-26" href="#">მეტის ნახვა</a>
                    </div>
                  </div>

                  <div class="margin-top-34">
                    <div class="rating flex items-center">
                      <h3 class="color-dark-green font-size-md font-weight-600">შეფასება</h3>

                      <div class="rating__starts margin-left-24">
                        <img src="/images/stars.svg" alt="#">
                      </div>
                    </div>

                    <form class="form margin-top-24">
                      <div class="form__group form__group--material form__group--textarea">
                        <textarea class="form__element" id="rateContent" placeholder="დაამატეთ თქვენი შეფასება..."></textarea>
                        <label class="form__label" for="rateContent">დაამატეთ თქვენი შეფასება...</label>
                      </div>

                      <div class="flex space-between items-center margin-top-24">
                        <p class="color-black font-size-xs font-weight-400">
                          თქვენი შეფასება დაემატება მოდერაციის გავლის შემდეგ
                        </p>

                        <button type="button" class="button button--primary button--shadow button--border">შეფასების დამატება</button>
                      </div>
                    </form>
                  </div>

                  <div class="review margin-top-48">
                    <div class="review__body">
                      <div class="review__left">
                        <img src="/images/stars.svg" alt="#">
                        <h4 class="font-weight-600 padding-top-8">უბრალოდ საუკეთესო!</h4>
                        <h6 class="color-dark-green font-weight-600 padding-top-12">ირაკლი ქვათაძე</h6>
                      </div>

                      <p class="color-dark-green opacity-60 font-weight-300 line-height-default padding-left-16">
                        კომპანიის ცენტრალური ოფისი და საწყობი მდებარეობს თბილისში. პროდუქცია წარმოდგენილია „აგროსფერო“-ს სერვისცენტრებში და ოფიციალურ პარტნიორებთან, საქართველოს სხვადასხვა რეგიონში. ონლაინ მაღაზია agrosphere.ge-ს საშუალებით ჩვენი პროდუქცია იმისათვის რომ სასურველ შედეგს მივაღწიოთ, მხარში ვუდგავართ ფერმერებს, ვახორციელებთ მათი მეურნეობების მონიტორინგს, ყოველთვის ადგილზე ვეცნობით არსებულ მდგომარეობას
                      </p>
                    </div>
                  </div>

                  <h4 class="font-weight-600 margin-top-48">მსგავსი ტრენინგები</h4>

                  <div class="row margin-top-24">
                    <template v-for="item in 2" :key="item">
                      <div class="col-lg-6">
                        <div class="card margin-bottom-44">
                          <div class="card__body">
                            <a href="#" class="card__image" title="სათაური">
                              <img src="https://dummyimage.com/352x180/b3b3b3/fff.jpg" alt="სათაური">
                            </a>

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
              </div>
            </div>

          <drawer
              title="ირაკლი ქვათაძე"
              sub-title="აგრო-ინჟინერიის დოქტორი, ტრენერი, ლექტორი."
              width="708px"
          >
            <template v-slot:body>
              <p class="font-weight-300 line-height-default">
                მამუკა, თავისი კარიერის განმავლობაში ძალიან აქტიურად იღებდა და იღებს
                მონაწილეობას მექანიზაციის მიმართულებით ტრენინგებში, სამიტებზე,
                კონფერენციებსა და ა.შ მათ შორისაა:
                <br><br>
                „SYSTEMTECHNIK - CLAAS Global Seles GmbH“, (ჰარზევინკელი, გერმანია)
                I- ევრაზიის საერთაშორისო მექანიზაციის სამიტი - სტამბული, თურქეთი
                სასოფლო-სამეურნეო მანქანები - ედე, ჰოლანდია.
                <br><br>
                Land Technic-VDI-გერმანელ ინჟინერთა ასოციაცია ჰანოვერი, გერმანია
                <br><br>
                MASHAV–CINADCO-ტრეინინგ ცენტრი, თელავივი, ისრაელი.
                <br><br>
                მამუკა ასევე, არის - აგროინჟინერიისა და მექანიკის ინჟინერიის პროგრამის
                ხელმძღვანელი აგრარულ უნივერსიტეტში, საინჟინრო-ტექნოლოგიური
                ფაკულტეტის დეკანი და ასოცირებული პროფესორი, მას ძალიან აქტიურად
                უწევს მუშაობა სხვადასხვა პროექტებსა და გრანტებში ხელმძღვანელის და
                მრჩეველის პოზიციებზე.
              </p>
            </template>
          </drawer>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import CashIcon from "@/Components/Web/Icons/Cash";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import Drawer from "@/Components/Web/Drawer/Drawer";
import emitter from "@/Plugins/bus";

export default {
    components: {
        Landing,
        Breadcrumb,
        CalendarIcon,
        CashIcon,
        Drawer
    },

    methods: {
      handleShowProgram () {
        emitter.emit('showDrawer')
      }
    }
}
</script>
