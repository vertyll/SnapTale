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

const showBanner = ref(false);

onMounted(() => {
    const cookiesAccepted = localStorage.getItem("cookies_accepted");
    if (!cookiesAccepted) {
        showBanner.value = true;
    }
});

const acceptCookies = () => {
    localStorage.setItem("cookies_accepted", "true");
    showBanner.value = false;
};
</script>