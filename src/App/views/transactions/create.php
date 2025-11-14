<?php include $this->resolve("partials/_header.php"); ?>

<section class="max-w-2xl mx-auto mt-4 md:mt-12 px-4 lg:px-0">
  <div class="bg-white shadow-md border border-gray-200 rounded-lg p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 text-center">Create New Transaction</h2>
    <form method="POST" class="grid grid-cols-1 gap-4 md:gap-6">
    <?php include $this->resolve("partials/_csrf.php"); ?>

    <label class="block">
      <span class="text-gray-700">Description</span>
      <input value="<?php echo e($oldFormData['description'] ?? ''); ?>" name="description" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
      <?php if (array_key_exists('description', $errors)) : ?>
        <div class="bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['description'][0]); ?>
        </div>
      <?php endif; ?>
    </label>
    <label class="block">
      <span class="text-gray-700">Amount</span>
      <input value="<?php echo e($oldFormData['amount'] ?? ''); ?>" name="amount" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
      <?php if (array_key_exists('amount', $errors)) : ?>
        <div class="bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['amount'][0]); ?>
        </div>
      <?php endif; ?>
    </label>
    <label class="block">
      <span class="text-gray-700">Date</span>
      <input value="<?php echo e($oldFormData['date'] ?? ''); ?>" name="date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
      <?php if (array_key_exists('date', $errors)) : ?>
        <div class="bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['date'][0]); ?>
        </div>
      <?php endif; ?>
    </label>
    
    <button type="submit" class="block w-full mt-2 py-2 bg-indigo-600 text-white rounded">
      Create Transaction
    </button>
      
      <div class="text-center mt-4">
        <a href="/" class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">← Back to Transactions</a>
      </div>
    </form>
  </div>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>