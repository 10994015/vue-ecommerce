<script setup>

  import { ref, onMounted, onUnmounted, computed } from "vue";
  import Spinner from "../components/core/Spinner.vue"
  import Sidebar from "../components/Sidebar.vue"
  import store from "../store";
  import Navbar from "./Navbar.vue"
  const {title} = defineProps({
      title:String,
  });
  const handleSidebarOpened = ()=>{
    sidebarOpened.value =  window.outerWidth > 768;
  }
  onMounted(() => {
    store.dispatch('getUser');
    handleSidebarOpened();
    window.addEventListener('resize', handleSidebarOpened);
  })
  onUnmounted(() => {
    window.removeEventListener('resize', handleSidebarOpened);
  })

  const currentUser = computed(()=> store.state.user.data);

  const sidebarOpened = ref(true);
  const toggleSidebar = ()=>{
    sidebarOpened.value = !sidebarOpened.value;
  };
</script>

<template>
    <div class="flex min-h-full bg-gray-100" v-if="currentUser.id">
      <Sidebar :class="{'-ml-[200px]':!sidebarOpened}" />
      <div class="flex-1">
        <Navbar @toggle-sidebar="toggleSidebar" />
        <main class="p-6">
          <router-view></router-view>
        </main>
      </div>
    </div>
    <div v-else class="min-h-full flex items-center justify-center bg-gray-200 ">
        <Spinner />
    </div>
</template>

<style lang="scss" scoped>

</style>