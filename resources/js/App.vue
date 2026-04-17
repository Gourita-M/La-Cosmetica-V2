<template>
  <header class="docked full-width top-0 z-50 bg-[#f7f9fc] dark:bg-slate-950 shadow-sm dark:shadow-none">
        <div class="flex items-center justify-between px-8 w-full h-20 max-w-screen-2xl mx-auto">
            <div class="flex items-center gap-12">
                <span class="text-2xl font-extrabold text-[#00478d] dark:text-blue-400 tracking-tighter">Digital
                    Atelier</span>
                <nav class="hidden md:flex gap-8 items-center font-['Manrope'] font-semibold tracking-tight">
                    <a class="text-[#00478d] dark:text-blue-400 border-b-2 border-[#00478d] pb-1 transition-colors duration-200"
                        href="#">Storefront</a>
                    <a class="text-slate-500 dark:text-slate-400 hover:text-[#00478d] transition-colors duration-200"
                        href="#">Orders</a>
                    <a class="text-slate-500 dark:text-slate-400 hover:text-[#00478d] transition-colors duration-200"
                        href="#">Inventory</a>
                    <a class="text-slate-500 dark:text-slate-400 hover:text-[#00478d] transition-colors duration-200"
                        href="#">Account</a>
                    <a class="text-slate-500 dark:text-slate-400 hover:text-[#00478d] transition-colors duration-200"
                        href="#">Admin</a>
                </nav>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex items-center bg-surface-container-low px-4 py-2 rounded-full">
                    <span class="material-symbols-outlined text-outline mr-2" data-icon="search">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-sm w-48 font-body"
                        placeholder="Search the collection..." type="text" />
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 hover:bg-[#e6e8eb] rounded-full transition-colors"><span
                            class="material-symbols-outlined text-on-surface-variant"
                            data-icon="shopping_cart">shopping_cart</span></button>
                    <button class="p-2 hover:bg-[#e6e8eb] rounded-full transition-colors"><span
                            class="material-symbols-outlined text-on-surface-variant"
                            data-icon="notifications">notifications</span></button>
                    <button class="p-2 hover:bg-[#e6e8eb] rounded-full transition-colors"><span
                            class="material-symbols-outlined text-on-surface-variant"
                            data-icon="help">help</span></button>
                    <div class="w-10 h-10 rounded-full overflow-hidden ml-2 border-2 border-primary-container">
                        <img alt="Avatar"
                            data-alt="professional portrait of a man with a friendly smile, studio lighting, clean background"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0ohAhmbvwFMcWKBHgihrYvN3C4xlkoMSaZOq027Yzs42-oQIPgyaTcgzLP2-eSs8xEatv8LsjO_assFg2MJnzVkdJoDFCS0ausmKA5ym8cxGueRJgdcwvWuylTUj6ypruVxZ3pcmNWu-SNRNk--Z2icSeYYgFRi9H1XOuIzoN4zLSWx1h0fMVILrujig8hrL4vyMi5K-NIZjYSANI5terKCU8-7CSSxIVUfegjIFOJsRQx09AQLYrGbZ8n_hp3uDD9wC8Np9q4v8" />
                    </div>
                </div>
            </div>
        </div>
    </header>
  <nav>
    <router-link to="/products">Products</router-link>
    <router-link to="/order">Order</router-link>
    <button @click="logout">Logout</button>
  </nav>

  <router-view />
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>