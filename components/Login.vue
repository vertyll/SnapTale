<template>
  <div class="text-center text-[28px] mb-4 font-bold">Zaloguj się</div>

  <div class="px-6 pb-2">
    <TextInput
      placeholder="Adres e-mail"
      v-model:input="email"
      inputType="email"
      :autoFocus="true"
      :error="errors && errors.email ? errors.email[0] : ''"
    />
  </div>

  <div class="px-6 pb-2">
    <TextInput
      placeholder="Hasło"
      v-model:input="password"
      inputType="password"
    />
  </div>

  <div class="px-6 pb-2 mt-6">
    <button
      :disabled="!email || !password"
      :class="!email || !password ? 'bg-gray-200' : 'bg-[#bc2cf0]'"
      @click="login()"
      class="w-full text-[17px] font-semibold text-white py-3 rounded-sm"
    >
      Zaloguj
    </button>
  </div>
</template>

<script setup>
const { $userStore, $generalStore } = useNuxtApp();

let email = ref(null);
let password = ref(null);
let errors = ref(null);

const login = async () => {
  errors.value = null;

  try {
    await $userStore.getTokens();
    await $userStore.login(email.value, password.value);
    await $userStore.getUser();
    await $generalStore.getRandomUsers("suggested");
    await $generalStore.getRandomUsers("following");
    $generalStore.isLoginOpen = false;
  } catch (error) {
    errors.value = error.response.data.errors;
  }
};
</script>
