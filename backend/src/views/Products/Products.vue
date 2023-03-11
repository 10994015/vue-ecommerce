<script setup>
import ProductsTable from "./ProductsTable.vue"
import ProductModal from "./ProductModal.vue"
import { ref } from "vue";

const showModal = ref(false);

function closeModal(bool) {
    showModal.value = bool
}

const showProductModal = ()=>{
    showModal.value = true;
};
</script>

<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Products</h1>
        <button @click="showProductModal" type="submit" class="flex justify-center py-2 px-4 border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
            Add new Product
        </button>
        
    </div>
    <ProductModal :modalValue="showModal" @closeModal="closeModal" />
    <ProductsTable />
</template>

<style lang="scss" scoped>

</style>