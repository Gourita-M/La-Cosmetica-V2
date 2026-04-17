<template>
  <div class="space-y-4">
    <div>
        <label class="block text-gray-700 mb-1" for="email">Email</label>
        <input type="email" id="email" v-model="email" required
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"/>
      </div>

      <div>
        <label class="block text-gray-700 mb-1" for="password">Password</label>
        <input v-model="password" type="password" id="password" required
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"/>
      </div>

      <button @click="login"
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
        Login
      </button>
      <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('');
const password = ref('');
const error = ref('');
const router = useRouter();

const login = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    })

    localStorage.setItem('token', response.data.token);

    localStorage.setItem('user', JSON.stringify(response.data.user));

    router.push('/products');
  } catch (err) {
    error.value = 'Login failed'
  }
}
</script>