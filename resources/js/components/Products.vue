<template>
            <div v-for="product in products" :key="product.id"
                class="group flex flex-col bg-surface-container-lowest rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl relative">
                <div class="aspect-[4/5] relative overflow-hidden bg-surface-container">
                    <img alt="Product"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        data-alt="modern medical glass vial with glowing blue liquid inside, clean clinical lab setting, soft cinematic lighting"
                        :src="product.image" />
                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-tertiary-fixed text-on-tertiary-fixed px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Bio</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-on-surface">{{ product.name }}</h3>
                        <span class="text-lg font-bold text-primary">$189.00</span>
                    </div>
                    <p class="text-sm text-on-surface-variant line-clamp-2 mb-6 font-body leading-relaxed">
                        Enhanced synaptic transmission complex for peak cognitive performance during heavy data
                        analysis.
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                        <a class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors"
                            href="/products/neuro-sync-serum">Details available via slug</a>
                        <button
                            class="flex items-center gap-2 bg-primary text-on-primary px-4 py-2 rounded-md font-semibold text-sm hover:opacity-90 transition-opacity">
                            <span class="material-symbols-outlined text-sm"
                                data-icon="add_shopping_cart">add_shopping_cart</span>
                            Order
                        </button>
                    </div>
                </div>
            </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([]);

const fetchProducts = async () => {
  const response = await axios.get('http://127.0.0.1:8000/api/products', {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  })
  products.value = response.data
}

onMounted(() => {
  fetchProducts()

  setInterval(() => {
    fetchProducts()
  }, 5000)
})
</script>