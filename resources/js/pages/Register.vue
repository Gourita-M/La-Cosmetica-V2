<template>
    <div class="space-y-4">
        <div>
            <label class="block text-gray-700 mb-1" for="name">Name</label>
            <input type="text" id="name" v-model="name" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"/>
        </div>

        <div>
            <label class="block text-gray-700 mb-1" for="email">Email</label>
            <input type="email" id="email" v-model="email" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"/>
        </div>

        <div>
            <label class="block text-gray-700 mb-1" for="password">Password</label>
            <input type="password" id="password" v-model="password" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"/>
        </div>

        <div>
            <label class="block text-gray-700 mb-1" for="password_confirmation">role</label>
            <input type="text" id="password_confirmation" v-model="role" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"/>
        </div>

        <button @click="Register"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
            Register
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const name = ref('');
const role = ref('');
const email = ref('');
const password = ref('');
const error = ref('');
const router = useRouter();

const Register = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      role: role.value
    })

    localStorage.setItem('user', JSON.stringify(response.data.user));

    router.push('/login');

  } catch (err) {
    error.value = err.response?.data?.error || 'Register failed'
  }
}
</script>