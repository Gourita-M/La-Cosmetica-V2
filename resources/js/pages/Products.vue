<template>
    <main class="flex-grow w-full max-w-screen-2xl mx-auto px-8 py-12">
        <!-- Hero & Title Section -->
        <section class="mb-16">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-5xl font-extrabold tracking-tight text-on-surface mb-4">Curated Excellence</h1>
                    <p class="text-on-surface-variant max-w-xl text-lg font-body leading-relaxed">
                        Welcome to the Digital Atelier Storefront. Browse our high-performance biologics and hydration
                        solutions, precisely engineered for the modern workflow.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button
                        class="px-6 py-2 rounded-full bg-primary text-on-primary font-semibold text-sm shadow-md bg-gradient-to-r from-primary to-primary-container">All
                        Collections</button>
                    <button
                        class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors">Bio-Engineering</button>
                    <button
                        class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors">Hydration
                        Pro</button>
                    <button
                        class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors">Sustain
                        Systems</button>
                </div>
            </div>
        </section>
    <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <div
            v-for="product in products"
            :key="product.id"
            class="group flex flex-col bg-surface-container-lowest rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl relative">
            <div
                class="aspect-[4/5] relative overflow-hidden bg-surface-container">
                <img
                    alt="Product"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    data-alt="modern medical glass vial with glowing blue liquid inside, clean clinical lab setting, soft cinematic lighting"
                    :src="product.image"/>
                <div class="absolute top-4 left-4">
                    <span
                        class="bg-tertiary-fixed text-on-tertiary-fixed px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                        Bio</span>
                </div>
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-on-surface">
                        {{ product.name }}
                    </h3>
                    <span class="text-lg font-bold text-primary">{{product.price}} DH</span>
                </div>
                <p
                    class="text-sm text-on-surface-variant line-clamp-2 mb-6 font-body leading-relaxed">
                    Enhanced synaptic transmission complex for peak cognitive
                    performance during heavy data analysis.
                </p>
                <div class="mt-auto flex items-center justify-between">
                    <a
                        class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors"
                        href="/products/neuro-sync-serum"
                        >Details available via slug</a>
                    <button @click="openModal(product)"
                        class="flex items-center gap-2 bg-primary text-on-primary px-4 py-2 rounded-md font-semibold text-sm hover:opacity-90 transition-opacity">
                        <span
                            class="material-symbols-outlined text-sm"
                            data-icon="add_shopping_cart">
                            add_shopping_cart</span>
                        Order
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div v-if="showModel"
                class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div
                    class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl w-full max-w-md p-6 relative">
                    <button @click="closeModal"
                        class="absolute top-3 right-3 text-slate-400 hover:text-slate-700">
                        ✕
                    </button>

                    <h2 class="text-2xl font-bold text-on-surface mb-4">
                        Order Product
                    </h2>

                    <div class="mb-4">
                        <p class="text-sm text-on-surface-variant">Product</p>
                        <p class="font-semibold text-lg">{{ selectedProduct.name }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-on-surface-variant">Price</p>
                        <p class="font-semibold text-lg">{{ selectedProduct.price }} DH</p>
                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-sm text-on-surface-variant mb-1">
                            Quantity
                        </label>
                        <input
                            type="number"
                            min="1"
                            value="1"
                            class="w-full border border-outline rounded-lg p-2 focus:ring-2 focus:ring-primary outline-none"/>
                    </div>

                    <div class="flex gap-3">
                        <button @click="closeModal"
                            class="flex-1 py-2 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition">
                            Cancel
                        </button>

                        <button @click="order(selectedProduct)"
                            class="flex-1 py-2 rounded-lg bg-primary text-white hover:bg-primary-container transition">
                            Confirm Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <!-- Footer -->
    <footer class="full-width border-t border-slate-200 dark:border-slate-800 bg-[#f2f4f7] dark:bg-slate-950 mt-20">
        <div
            class="flex flex-col md:flex-row justify-between items-center px-12 py-10 w-full max-w-screen-2xl mx-auto">
            <div class="flex flex-col items-center md:items-start mb-6 md:mb-0">
                <span class="font-['Manrope'] font-bold text-[#00478d] text-xl mb-2">Digital Atelier</span>
                <p class="font-['Inter'] text-sm text-slate-500 dark:text-slate-400">© 2024 The Digital Atelier
                    Management System</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8 font-['Inter'] text-sm">
                <a class="text-slate-500 dark:text-slate-400 hover:underline" href="#">Store Info</a>
                <a class="text-slate-500 dark:text-slate-400 hover:underline" href="#">Privacy Policy</a>
                <a class="text-slate-500 dark:text-slate-400 hover:underline" href="#">Terms of Service</a>
                <a class="text-slate-500 dark:text-slate-400 hover:underline" href="#">Help Center</a>
                <a class="text-slate-500 dark:text-slate-400 hover:underline" href="#">API Documentation</a>
            </div>
            <div class="mt-6 md:mt-0 flex gap-4">
                <span class="material-symbols-outlined text-slate-400 cursor-pointer hover:text-primary"
                    data-icon="public">public</span>
                <span class="material-symbols-outlined text-slate-400 cursor-pointer hover:text-primary"
                    data-icon="mail">mail</span>
                <span class="material-symbols-outlined text-slate-400 cursor-pointer hover:text-primary"
                    data-icon="share">share</span>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const showModel = ref(false);
const selectedProduct = ref(null);

const openModal = (product) => {
    selectedProduct.value = product;
    showModel.value = true;
}

const order = async (selectedProduct) => {
    await axios.post("")
}

const closeModal = () => {
  showModel.value = false
}

const products = ref([]);

const fetchProducts = async () => {
    const response = await axios.get("http://127.0.0.1:8000/api/products", {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    products.value = response.data;
};

onMounted(() => {
    fetchProducts();

    setInterval(() => {
        fetchProducts();
    }, 5000);
});
</script>
