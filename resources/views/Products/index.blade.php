<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    @vite('resources/js/app.js')
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-fixed-dim": "#bac7de",
                        "on-primary": "#ffffff",
                        "inverse-primary": "#a9c7ff",
                        "surface-container-high": "#e6e8eb",
                        "surface-variant": "#e0e3e6",
                        "on-tertiary": "#ffffff",
                        "primary-fixed": "#d6e3ff",
                        "surface-container-highest": "#e0e3e6",
                        "tertiary-fixed": "#8bf6d2",
                        "on-surface": "#191c1e",
                        "on-secondary-fixed-variant": "#3b485a",
                        "secondary": "#525f73",
                        "tertiary-fixed-dim": "#6edab6",
                        "surface": "#f7f9fc",
                        "secondary-container": "#d6e3fb",
                        "on-surface-variant": "#424752",
                        "primary-container": "#005eb8",
                        "outline-variant": "#c2c6d4",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#00468c",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed": "#002117",
                        "surface-container": "#eceef1",
                        "on-secondary-container": "#586579",
                        "outline": "#727783",
                        "on-tertiary-container": "#81edc9",
                        "primary": "#00478d",
                        "inverse-on-surface": "#eff1f4",
                        "surface-bright": "#f7f9fc",
                        "secondary-fixed": "#d6e3fb",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#f2f4f7",
                        "surface-tint": "#005db6",
                        "surface-dim": "#d8dadd",
                        "tertiary-container": "#006c54",
                        "tertiary": "#00523e",
                        "on-background": "#191c1e",
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed-variant": "#00513e",
                        "inverse-surface": "#2d3133",
                        "on-secondary-fixed": "#0f1c2d",
                        "background": "#f7f9fc",
                        "on-primary-fixed": "#001b3d",
                        "on-primary-container": "#c8daff",
                        "primary-fixed-dim": "#a9c7ff"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        .brand-logo {
            font-family: 'Manrope', sans-serif;
        }

        .glass-nav {
            background: rgba(247, 249, 252, 0.8);
            backdrop-filter: blur(20px);
        }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col">
    <!-- TopAppBar -->
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
        <!-- Product Grid -->
        <div id="Products" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            
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
</body>

</html>
