<template>
  <div
    id="AuthOverlay"
    class="fixed flex items-center justify-center z-50 top-0 left-0 w-full h-full bg-black bg-opacity-50"
  >
    <div class="relative bg-white w-full max-w-[470px] h-[70%] p-4 rounded-lg">
      <div class="w-full flex justify-end">
        <button
          @click="$generalStore.isLoginOpen = false"
          class="p-1.5 rounded-full bg-gray-100"
        >
          <Icon name="mdi:close" size="26" />
        </button>
      </div>

      <Login v-if="isRegister" />
      <Register v-else />

      <div
        class="absolute flex items-center justify-center py-5 left-0 bottom-0 border-t w-full"
      >
        <span v-if="isRegister" class="text-[14px] text-gray-600"
          >Nie masz konta?</span
        >
        <span v-else class="text-[14px] text-gray-600">Masz już konto?</span>
        <button
          @click="isRegister = !isRegister"
          class="text-[14px] text-[#9b2cf0] font-semibold pl-1"
        >
          <span v-if="isRegister">Rejestracja</span>
          <span v-else>Zaloguj</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const { $generalStore } = useNuxtApp();
let isRegister = ref(true);
</script>
