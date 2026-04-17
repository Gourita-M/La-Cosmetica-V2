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
<body>
    <div id="app"></div>
</body>
</html>