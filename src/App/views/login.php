<?php include $this->resolve("partials/_header.php"); ?>

<section class="max-w-2xl mx-auto mt-4 md:mt-12 px-4 lg:px-0">
  <div class="bg-white shadow-md border border-gray-200 rounded-lg p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 text-center">Login to Your Account</h2>
    <form method="POST" class="grid grid-cols-1 gap-4 md:gap-6">
    <?php include $this->resolve("partials/_csrf.php"); ?>
    
    <?php if (array_key_exists('general', $errors)): ?>
    <div class="bg-red-50 border border-red-200 p-3 text-red-600 text-sm rounded mb-4">
      <?php echo e($errors['general'][0]); ?>
    </div>
    <?php endif; ?>

      <label class="block">
        <span class="text-gray-700 text-sm md:text-base font-medium">Email address</span>
        <input value="<?php echo e($oldFormData ['email'] ?? ''); ?>" name="email" type="email" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 md:py-3 text-sm md:text-base" placeholder="john@example.com" />
        <?php if (array_key_exists('email', $errors)): ?>
        <div class="bg-red-50 border border-red-200 mt-2 p-2 text-red-600 text-sm rounded">
          <?php echo e($errors['email'][0]); ?>
        </div>
        <?php endif; ?>
      </label>
      
      <label class="block">
        <span class="text-gray-700 text-sm md:text-base font-medium">Password</span>
        <input name="password" type="password" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 md:py-3 text-sm md:text-base" placeholder="Enter your password" />
        <?php if (array_key_exists('password', $errors)): ?>
        <div class="bg-red-50 border border-red-200 mt-2 p-2 text-red-600 text-sm rounded">
          <?php echo e($errors['password'][0]); ?>
        </div>
        <?php endif; ?>
      </label>
      
      <button type="submit" class="block w-full mt-2 py-2 bg-indigo-600 text-white rounded">
        Sign In
      </button>
      
      <div class="text-center mt-4">
        <p class="text-sm text-gray-600">
          Don't have an account? 
          <a href="/register" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign up here</a>
        </p>
      </div>
    </form>
  </div>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>