<template>
  <div v-if="sliders.length > 0" class="slider-container">
    <section class="ps-section--banner">
      <div class="ps-section__overlay">
        <div class="ps-section__loading"></div>
      </div>
      <carousel dir="rtl" :autoplay="3000" :wrapAround="true" :items-to-show="1">
        <slide v-for="slider in sliders" :key="slider.id">
          <div class="ps-banner" :style="`background-color:${slider.color}`">
            <div class="container container-initial">
              <div class="ps-banner__block">
                <div class="ps-banner__content">
                  <h2 class="ps-banner__title">{{ slider.title }}</h2>
                  <a
                    v-if="slider.external"
                    class="bg-white ps-banner__shop"
                    target="_blank"
                    :href="slider.url"
                    >{{ $t("SHOW_DETAILS") }}
                  </a>
                  <router-link
                    class="bg-white ps-banner__shop"
                    v-if="!slider.external"
                    :to="`product-details/${slider.product_id}`"
                  >
                    {{ $t("SHOW_DETAILS") }}
                  </router-link>
                </div>
                <div class="ps-banner__thumnail">
                  <img
                    class="ps-banner__image"
                    :src="slider.image"
                    alt="alt"
                  />
                </div>
              </div>
            </div>
          </div>
        </slide>
        <template #addons>
          <navigation />
        </template>
      </carousel>
    </section>
  </div>
</template>

<script>
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Navigation } from "vue3-carousel";
import homeClient from "../../shared/http-clients/home-client";
import { onMounted, reactive, toRefs } from "vue-demi";
import store from "../../shared/store";
import global from "../../shared/consts/global";
export default {
  components: {
    Carousel,
    Slide,
    Navigation,
  },
  setup() {
    let data = reactive({
      sliders: [],
    });
    onMounted(() => {
      store.showLoader = true;
      homeClient.getSliders().then((response) => {
        data.sliders = response.data;
        store.showLoader = false;
      });
    });
    //Methods
    //Commons
    return { ...toRefs(data) };
  },
};
</script>

<style lang="scss">
.slider-container {
  margin: 5px 0;
  .ps-banner {
    width: 100%;
    h2,
    a {
      z-index: 600 !important;
    }
  }
  .carousel__next,
  .carousel__prev {
    width: 53px;
    height: 53px;
    background: rgba(16, 49, 120, 0.1) !important;
    border: none;
    padding: 0 !important;
    color: white;
    font-size: 30px;
  }
  .carousel__next {
    left: 60px !important;
  }
  .carousel__prev {
    right: 60px !important;
  }
  .carousel__next:hover,
  .carousel__prev:hover {
    background-color: #0e67d0 !important;
  }
}
</style>
