<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo e($title); ?> - PHPiggy</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/main.css" />
</head>

<body class="bg-indigo-50 font-['Outfit']">
  <!-- Start Header -->
  <header class="bg-indigo-900">
    <nav class="mx-auto flex container items-center justify-between py-4 px-4 lg:px-0" aria-label="Global">
      <a href="/" class="-m-1.5 p-1.5 text-white text-xl md:text-2xl font-bold">PHPiggy</a>
      <!-- Navigation Links -->
      <div class="flex items-center space-x-6 md:space-x-8 lg:space-x-10">
        <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/" class="text-gray-300 hover:text-white transition px-1 py-1">Home</a>
        <?php endif; ?>
        <a href="/about" class="text-gray-300 hover:text-white transition px-4 py-1">About</a>
        <?php if (isset($_SESSION['user_id'])): ?>
        <button onclick="openLogoutModal()" class="text-gray-300 hover:text-white transition cursor-pointer px-2 py-1 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
          </svg>

          Logout
        </button>
        <?php else: ?>
          <a href="/login" class="text-gray-300 hover:text-white transition px-2 py-1">Login</a>
        <a href="/register" class="text-gray-300 hover:text-white transition px-4 py-1">Register</a>
         <?php endif; ?> 
      </div>
    </nav>
  </header>
  <!-- End Header -->

  <!-- Logout Confirmation Modal -->
  <?php if (isset($_SESSION['user_id'])): ?>
  <div id="logoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #f3f4f6; padding: 30px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); max-width: 400px; width: 90%;">
      <div style="text-align: center;">
        <div style="margin: 0 auto 20px; width: 60px; height: 60px; background-color: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
          <svg style="width: 30px; height: 30px; color: #f59e0b;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
          </svg>
        </div>
        <h3 style="font-size: 20px; font-weight: 600; color: #111827; margin-bottom: 15px;">Confirm Logout</h3>
        <p style="font-size: 14px; color: #6b7280; margin-bottom: 25px; line-height: 1.5;">
          Are you sure you want to logout? You will need to login again to access your account.
        </p>
        <div style="display: flex; justify-content: center; gap: 10px;">
          <button onclick="confirmLogout()" style="padding: 10px 20px; background-color: #dc2626; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
            Yes, Logout
          </button>
          <button onclick="closeLogoutModal()" style="padding: 10px 20px; background-color: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
  function openLogoutModal() {
    document.getElementById('logoutModal').style.display = 'block';
  }

  function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
  }

  function confirmLogout() {
    window.location.href = '/logout';
  }

  // Close modal when clicking outside
  document.getElementById('logoutModal')?.addEventListener('click', function(e) {
    if (e.target === this || e.target.classList.contains('bg-black')) {
      closeLogoutModal();
    }
  });

  // Close modal with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeLogoutModal();
    }
  });
  </script>
  <?php endif; ?>