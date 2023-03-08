<script setup>
    const {title} = defineProps({
        title:String,
    });
</script>

<template>
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md space-y-8">
        <div>
          Part of the layout
        </div>
        <router-view></router-view>
      </div>
    </div>
</template>

<style lang="scss" scoped>

</style>