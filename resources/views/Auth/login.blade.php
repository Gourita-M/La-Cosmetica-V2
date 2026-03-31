<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  @vite('resources/js/app.js')
  <title>Login - La Cosmetica</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-green-700 mb-6">Login</h1>

    <div id="Login"></div>
    
    <p class="text-sm text-gray-500 mt-4 text-center">
      Don't have an account? <a href="/register" class="text-green-600 hover:underline">Register</a>
    </p>
  </div>
</body>
</html>