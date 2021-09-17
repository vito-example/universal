<template>
    <portal class="conference-page">
        <template v-slot:main>

            <div class="conference-page-content">
                <div class="conference-page-left">
                    <c-card class="card-accent-primary">
                        <template v-slot:header>
                            {{ __('Speakers') }}
                        </template>
                        <template v-slot:body>
                            <ul class="list_teachers">
                                <li v-for="spekaer in item.speakers">
                                    <figure>
                                        <img :src="spekaer.image_url" alt="" class="img-rounded">
                                    </figure>
                                    <h5>{{ spekaer.label }}</h5>
                                    <Tooltip :tooltipText="spekaer.sub_title" v-if="spekaer.sub_title">
                                        <button class="font-xl mt-2"><i class="pe-7s-info"></i></button>
                                    </Tooltip>
                                </li>
                            </ul>
                        </template>
                    </c-card>
                </div>

                <div class="conference-page-item">
                    <c-card class="card-accent-primary">
                        <template v-slot:header>
                            {{ item.title }}
                        </template>
                        <template v-slot:body>
                            <div class="embed-responsive embed-responsive-16by9">
                                <span v-html="item.iframe"></span>
                            </div>
                        </template>
                    </c-card>

                    <questions :item="item"></questions>

                    <template v-if="item.files.length">
                        <div class="indent_title_in">
                            <i class="pe-7s-cloud-download"></i>
                            <h3>{{ __('Conference Downloads') }}</h3>
                        </div>
                        <div class="wrapper_indent">
                            <div class="row">
                                <template v-for="file in item.files">
                                    <div class="col-md-6 col-sm-3">
                                        <a target="_blank" download style="color: white;font-weight: bold;" :href="file.file" class="btn btn-success btn-pill button_download hvr-sweep-to-right">
                                            {{ file.name }}
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="conference-page-right">
                    <div v-for="banner in item.banners" class="conference-page-banner is-large">
                        <div class="conference-page-banner-title pb-3" v-if="getBannerValueByKey(banner,'name')">
                            {{ getBannerValueByKey(banner, 'name') }}
                        </div>
                        <a :href="getBannerValueByKey(banner,'url')" target="_blank">
                            <img :alt="getBannerValueByKey(banner,'name')" :src="getBannerValueByKey(banner,'image')">
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </portal>
</template>

<script>
import Portal from "@/Layouts/Portal";
import BreadcrumbItem from "@/Components/BreadcrumbItem";
import CCard from "@/CoreUi/components/Card";
import Questions from "@/Components/Event/Questions";
import Tooltip from "@/Components/Tooltip";

export default {
    components: {
        Questions,
        Portal,
        BreadcrumbItem,
        CCard,
        Tooltip
    },
    props: {
        item: {
            type: Object
        }
    },
    methods: {
        getFieldValue(fields, key) {
            var value = ''
            fields.forEach((field) => {
                if (field.key == key) {
                    value = field.value
                }
            })

            return value
        },
        getBannerValueByKey(fields, key) {
            var value = ''
            fields.forEach((field) => {
                if (!value && field.key === key) {
                    value = field.value
                }
            })
            return value
        }
    }
}
</script>
