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
    isFollowing: false,
  }),
  actions: {
    async getProfile(id) {
      this.resetUser();
      const { $axios } = useNuxtApp();

      const [profileRes, followCountRes, isFollowingRes] = await Promise.all([
        $axios.get(`/api/profiles/${id}`),
        $axios.get(`/api/follows/count/${id}`),
        $axios.get(`/api/follows/check/${id}`),
      ]);

      const userData = profileRes.data.user[0];
      this.$state.id = userData.id;
      this.$state.name = userData.name;
      this.$state.bio = userData.bio;
      this.$state.image = userData.image;
      this.$state.posts = profileRes.data.posts;

      this.allLikesCount();
      this.followCount = followCountRes.data.follow_count || 0;
      this.isFollowing = isFollowingRes.data.is_following;
    },
    async getFollowCount(userId) {
      const { $axios } = useNuxtApp();
      let res = await $axios.get(`/api/follows/count/${userId}`);
      return res.data.follow_count || 0;
    },
    allLikesCount() {
      this.allLikes = this.posts.reduce(
        (sum, post) => sum + post.likes.length,
        0
      );
    },
    resetUser() {
      Object.assign(this.$state, {
        id: "",
        name: "",
        bio: "",
        image: "",
        posts: [],
        allLikes: 0,
        followCount: 0,
        isFollowing: false,
      });
    },
  },
  persist: true,
});
