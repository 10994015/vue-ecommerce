<script setup>
import { ref, computed, onUpdated } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import Spinner from "../../components/core/Spinner.vue"
import store from '../../store';

const loading = ref(false);

const product = ref({
  id: props.product.id,
  title: props.product.title,
  image: props.product.image,
  description: props.product.description,
  price: props.product.price,
})

const props = defineProps({
    modalValue: Boolean,
    product:{
      required: true,
      type: Object,
    }
});
const emits = defineEmits(['closeModal'])
const show = computed(() => props.modalValue);
const isOpen = ref(false)

onUpdated(() => {
  product.value = {
    id: props.product.id,
    title: props.product.title,
    image: props.product.image,
    description: props.product.description,
    price: props.product.price,
  }
})

function closeModal() {
  emits("closeModal", false)
}
function openModal() {
  isOpen.value = true
}

const onSubmit = ()=>{
  loading.value = true;
  if(product.value.id){
    store.dispatch('updateProduct', product.value).then(res=>{
      loading.value = false;
      if(res.status === 200){
        store.dispatch('getProducts')
        closeModal();
      }
    })
  }else{
    store.dispatch('createProduct', product.value).then(res=>{
      loading.value = false;
      if(res.status === 201){
        store.dispatch('getProducts')
        closeModal();
      }
    })
  }
};
</script>

<template>
    
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-10">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black bg-opacity-25" />
        </TransitionChild>
  
        <div class="fixed inset-0 overflow-y-auto">
          <div
            class="flex min-h-full items-center justify-center p-4 text-center"
          >
            <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
              >
               <Spinner v-if="loading" class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center" />
                <header class="py-3 px-4 flex justify-between items-center">
                  <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                    {{ product.id ? `Update product: "${props.product.title}"` : `Create new Product` }}
                  </DialogTitle>
                  <button @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0, .2)]"></button>
                </header>
                <form @submit.prevent="onSubmit">
                    <div class="bg-white px-4 pt-5 pb-4">
                      <CustomInput class="mb-2" v-model="product.title" label="Product Title" />
                      <CustomInput type="file" class="mb-2" label="Prodcut Image" @change="file => product.image = file" />
                      <CustomInput type="textarea" class="mb-2" v-model="product.description" label="Description" />
                      <CustomInput type="number" class="mb-2" v-model="product.price" label="Price" prepend="$" />
                    </div>
                    <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex-row-reverse">
                      <button type="submit" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                      <button type="button" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-black bg-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                    </footer>
                </form>

              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>
  
 
  

<style lang="scss" scoped>

</style>