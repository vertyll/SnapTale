<template>
  <MainLayout>
    <div v-if="$profileStore.name"
      class="pt-[90px] 2xl:pl-[185px] lg:pl-[160px] lg:pr-0 pr-2 w-[calc(100%-90px)] max-w-[1800px] 2xl:mx-auto">
      <div class="flex w-[calc(100vw-230px)]">
        <img class="max-w-[120px] rounded-full" :src="$profileStore.image" />
        <div class="ml-5 w-full">
          <div class="text-[30px] font-bold truncate">
            {{ $generalStore.allLowerCaseNoCaps($profileStore.name) }}
          </div>
          <div class="text-[18px] truncate">{{ $profileStore.name }}</div>
          <button v-if="$profileStore.id === $userStore.id" @click="$generalStore.isEditProfileOpen = true"
            class="flex item-center rounded-md py-1.5 px-3.5 mt-3 text-[15px] font-semibold border hover:bg-gray-100">
            <Icon class="mt-0.5 mr-1" name="mdi:pencil" size="18" />
            <div>Edytuj profil</div>
          </button>
          <button v-else @click="toggleFollow" :class="isFollowing ? 'bg-gray-300' : 'bg-[#bc2cf0] text-white'"
            class="flex item-center rounded-md py-1.5 px-8 mt-3 text-[15px] font-semibold">
            {{ isFollowing ? 'Przestań obserwować' : 'Obserwuj' }}
          </button>
        </div>
      </div>

      <div class="flex items-center pt-4">
        <div class="mr-4">
          <span class="font-bold">{{ allLikes }}</span>
          <span class="text-gray-500 font-light text-[15px] pl-1.5">Polubienia</span>
        </div>
        <div class="mr-4">
          <span class="font-bold">{{ followCount }}</span>
          <span class="text-gray-500 font-light text-[15px] pl-1.5">Obserwujący</span>
        </div>
      </div>

      <div class="pt-4 mr-4 text-gray-500 font-light text-[15px] pl-1.5 max-w-[500px]">
        {{ $profileStore.bio }}
      </div>

      <div class="w-full flex items-center pt-4 border-b">
        <div class="w-60 text-center py-2 text-[17px] font-semibold border-b-2 border-b-black">
          Filmy
        </div>
      </div>

      <div class="mt-4 grid 2xl:grid-cols-6 xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-3">
        <div v-if="show" v-for="post in $profileStore.posts">
          <PostUser :post="post" />
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from "~/layouts/MainLayout.vue";
import { storeToRefs } from "pinia";
import { ref, onMounted, watch } from "vue";
const { $userStore, $profileStore, $generalStore } = useNuxtApp();
const { posts, allLikes } = storeToRefs($profileStore);

const route = useRoute();
let show = ref(false);
let isFollowing = ref(false);
let followCount = ref(0);

definePageMeta({ middleware: "auth" });

onMounted(async () => {
  try {
    await $profileStore.getProfile(route.params.id);
    isFollowing.value = await $userStore.checkIfFollowing(route.params.id);
    followCount.value = await $profileStore.getFollowCount(route.params.id);
  } catch (error) {
    console.log(error);
  }
});

watch(
  () => posts.value,
  () => {
    setTimeout(() => (show.value = true), 300);
  }
);

const toggleFollow = async () => {
  try {
    if (isFollowing.value) {
      await $userStore.unfollowUser(route.params.id);
      followCount.value--;
    } else {
      await $userStore.followUser(route.params.id);
      followCount.value++;
    }
    isFollowing.value = !isFollowing.value;
  } catch (error) {
    console.log(error);
  }
};
</script>