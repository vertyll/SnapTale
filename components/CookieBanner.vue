<template>
    <div v-if="showBanner" class="fixed bottom-0 left-0 right-0 p-4 shadow-md z-50 bg-white border-t">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center">
            <p class="text-sm text-gray-700 mb-2 sm:mb-0">
                Ta strona używa plików cookie, aby poprawić Twoje doświadczenie.
                Korzystając z naszej strony, zgadzasz się na wykorzystanie plików cookie.
            </p>
            <div class="flex items-center">
                <button @click="acceptCookies" class="bg-[#bc2cf0] text-white px-4 py-2 rounded transition-colors">
                    Akceptuję
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const setCookie = (name, value, days) => {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
};

const getCookie = (name) => {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
};

const showBanner = ref(false);

onMounted(() => {
    const cookiesAccepted = getCookie("cookies_accepted");
    if (!cookiesAccepted) {
        showBanner.value = true;
    }
});

const acceptCookies = () => {
    setCookie("cookies_accepted", "true", 365);
    showBanner.value = false;
};
</script>
