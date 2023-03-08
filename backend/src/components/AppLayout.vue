<script setup>

  import { ref, onMounted, onUnmounted } from "vue";
  import Sidebar from "../components/Sidebar.vue"
  import Navbar from "./Navbar.vue"
  const {title} = defineProps({
      title:String,
  });
  const handleSidebarOpened = ()=>{
    sidebarOpened.value =  window.outerWidth > 768;
  }
  onMounted(() => {
    handleSidebarOpened();
    window.addEventListener('resize', handleSidebarOpened);
  })
  onUnmounted(() => {
    window.removeEventListener('resize', handleSidebarOpened);
  })
  const sidebarOpened = ref(true);
  const toggleSidebar = ()=>{
    sidebarOpened.value = !sidebarOpened.value;
  };
</script>

<template>
    <div class="flex min-h-full bg-gray-100">
      <Sidebar :class="{'-ml-[200px]':!sidebarOpened}" />
      <div class="flex-1">
        <Navbar @toggle-sidebar="toggleSidebar" />
        <main class="p-6">
          <router-view></router-view>
        </main>
      </div>
    </div>
</template>

<style lang="scss" scoped>

</style>