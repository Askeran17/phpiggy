<?php include $this->resolve("partials/_header.php"); ?>

<!-- Start Main Content Area -->
<section class="container mx-auto mt-4 md:mt-12 px-4 lg:px-0 max-w-3xl">
  <div class="bg-white shadow-lg border border-gray-200 rounded-lg p-4 md:p-8">
    <!-- Page Title -->
    <div class="text-center mb-6 md:mb-8">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">About PHPiggy</h1>
      <p class="text-base md:text-lg text-gray-600">Simple Expense Tracking</p>
    </div>

  <hr class="mb-8" />

  <!-- About Content -->
  <div class="space-y-8">
    <!-- What is PHPiggy -->
    <div class="text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">What is PHPiggy?</h2>
      <p class="text-gray-700 text-lg leading-relaxed">
        PHPiggy is a simple expense tracking app.<br>
        Track your money, see where it goes, and manage your budget easily.
      </p>
    </div>

    <!-- Key Features -->
    <div class="text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Features</h2>
      <div class="space-y-3">
        <p class="text-gray-700">• Track income and expenses</p>
        <p class="text-gray-700">• View financial reports</p>
        <p class="text-gray-700">• Secure user accounts</p>
        <p class="text-gray-700">• Works on all devices</p>
        <p class="text-gray-700">• Easy to use</p>
      </div>
    </div>

    <!-- Technology -->
    <div class="text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Built With</h2>
      <div class="flex justify-center gap-6">
        <div class="bg-blue-50 p-4 rounded-lg">
          <h3 class="font-semibold text-blue-800 text-lg">PHP</h3>
          <p class="text-blue-600">Backend</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
          <h3 class="font-semibold text-green-800 text-lg">MySQL</h3>
          <p class="text-green-600">Database</p>
        </div>
      </div>
    </div>

    <!-- Get Started -->
    <div class="bg-gray-50 p-6 rounded-lg text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Get Started</h2>
      <p class="text-gray-700 mb-6 text-lg">Ready to track your expenses?</p>
      <div class="flex justify-center gap-4">
        <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
          Register
        </a>
        <a href="/login" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">
          Login
        </a>
      </div>
    </div>
  </div>
</section>
<!-- End Main Content Area -->

<?php include $this->resolve("partials/_footer.php"); ?>