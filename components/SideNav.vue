<template>
  <div
    id="SideNav"
    :class="route.fullPath === '/' ? 'lg:w-[310px]' : 'lg:w-[220px]'"
    class="fixed z-20 bg-white pt-[70px] h-full lg:border-r-0 border-r w-[75px] overflow-auto"
  >
    <div class="lg:w-full w-[55px] mx-auto">
      <NuxtLink to="/">
        <MenuItem
          iconString="Dla Ciebie"
          colorString="#bc2cf0"
          sizeString="30"
        />
      </NuxtLink>

      <div class="border-b lg:ml-2 mt-2" />

      <div
        class="lg:block hidden text-xs text-gray-600 font-semibold pt-4 pb-2 px-2"
      >
        Sugerowane konta
      </div>

      <div class="lg:hidden block pt-3" />

      <div
        v-if="$generalStore.suggested"
        v-for="sug in $generalStore.suggested"
      >
        <div @click="isLoggedIn(sug)" class="cursor-pointer">
          <MenuItemFollow :user="sug" />
        </div>
      </div>

      <button class="lg:block hidden text-[#bc2cf0] pt-1.5 pl-2 text-[13px]">
        Zobacz wszystkie
      </button>

      <!-- <div v-if="$userStore.id">
          <div class="border-b lg:ml-2 mt-2" />
  
          <div
            class="lg:block hidden text-xs text-gray-600 font-semibold pt-4 pb-2 px-2"
          >
            Obserwujące konta
          </div>
  
          <div class="lg:hidden block pt-3" />
  
          <div
            v-if="$generalStore.following"
            v-for="fol in $generalStore.following"
          >
            <div @click="isLoggedIn(fol)" class="cursor-pointer">
              <MenuItemFollow :user="fol" />
            </div>
          </div>
  
          <button class="lg:block hidden text-[#bc2cf0] pt-1.5 pl-2 text-[13px]">
            Zobacz więcej
          </button>
        </div> -->

      <div class="lg:block hidden border-b lg:ml-2 mt-2" />

      <div class="lg:block hidden text-[11px] text-gray-500">
        <div class="pt-4 px-2">© 2023 SnapTale</div>
      </div>

      <div class="pb-14"></div>
    </div>
  </div>
</template>

<script setup>
const { $generalStore, $userStore } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const isLoggedIn = (fol) => {
  if (!$userStore.id) {
    $generalStore.isLoginOpen = true;
    return;
  }
  setTimeout(() => router.push(`/profile/${fol.id}`), 200);
};
</script>
