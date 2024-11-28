<template>
  <div>

    <Splash v-if="showSplash" />

    <div class="flex h-screen bg-gray-50" v-else>
      <Navigation />
      <NavigationMobile />

      <div class="flex flex-col flex-1 w-full">
        <TopMenu />

        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2 class="my-2 text-2xl font-semibold ">
              <slot name="header" />
            </h2>

            <slot />
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue';
import TopMenu from "./TopMenu.vue";
import NavigationMobile from './NavigationMobile.vue';

import Splash from '../Components/Splash.vue';
import { ref, onMounted } from 'vue';


const showSplash = ref(true);

onMounted(() => {
    if (localStorage.getItem('splashShown')) {
        showSplash.value = false;
    } else {
        setTimeout(() => {
            showSplash.value = false;
            localStorage.setItem('splashShown', 'true');
        }, 2500);
    }
});

</script>
