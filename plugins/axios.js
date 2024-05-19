import axios from 'axios';

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();

  const instance = axios.create({
    baseURL: config.public.apiBaseUrl,
    withCredentials: true,
  });

  instance.defaults.withXSRFToken = true;

  nuxtApp.provide('axios', instance);
});
