<template>
  <div>
    <h1>Products</h1>

    <ul>
      <li v-for="product in products" :key="product.id">
        {{ product.name }}
      </li>
    </ul>
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