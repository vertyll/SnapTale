import { defineStore } from "pinia";
import { useNuxtApp } from "#app";

export const useProfileStore = defineStore("profile", {
  state: () => ({
    id: "",
    name: "",
    bio: "",
    image: "",
    post: null,
    posts: [],
    allLikes: 0,
    followCount: 0,
  }),
  actions: {
    async getProfile(id) {
      this.resetUser();
      const { $axios } = useNuxtApp();
      let res = await $axios.get(`/api/profiles/${id}`);

      this.$state.id = res.data.user[0].id;
      this.$state.name = res.data.user[0].name;
      this.$state.bio = res.data.user[0].bio;
      this.$state.image = res.data.user[0].image;
      this.$state.posts = res.data.posts;

      this.allLikesCount();
      this.followCount = await this.getFollowCount(id);
    },

    async getFollowCount(userId) {
      const { $axios } = useNuxtApp();
      let res = await $axios.get(`/api/follows/count/${userId}`);
      return res.data.follow_count || 0;
    },

    allLikesCount() {
      this.allLikes = 0;
      for (let i = 0; i < this.posts.length; i++) {
        const post = this.posts[i];
        this.allLikes += post.likes.length;
      }
    },

    resetUser() {
      this.$state.id = "";
      this.$state.name = "";
      this.$state.bio = "";
      this.$state.image = "";
      this.$state.posts = [];
      this.$state.allLikes = 0;
      this.$state.followCount = 0;
    },
  },
  persist: true,
});
