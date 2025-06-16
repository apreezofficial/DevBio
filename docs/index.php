  <?php include '../includes/settings.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
      <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="/tailwind.js"></script>
      <link rel="stylesheet" href="./includes/font-awesome/css/all.css">
            <link rel="stylesheet" href="./includes/css/animation.css">
                <script src="/includes/js/theme.js"></script>
  <script>
  tailwind.config = { darkMode: 'class' }
</script>
</head>
<body class="bg-white text-gray-800 dark:bg-[#0D0D0D] dark:text-gray-100 transition-colors duration-300">
  <?php include '../includes/nav.php';?>
  <!-- Table of Contents -->
<div class="bg-[#0D0D0D] p-6 border-l-4 border-[#8A2BE2] rounded-2xl shadow-md mb-8">
    <h2 class="text-2xl font-bold text-[#EAEAEA] mb-4 flex items-center gap-2">
        📚 Table of Contents
    </h2>
    <ul class="space-y-3">
        <li>
            <a href="#introduction" class="text-[#8A2BE2] hover:underline text-lg">1. Introduction</a>
        </li>
        <li>
            <a href="#setup" class="text-[#8A2BE2] hover:underline text-lg">2. Setup</a>
        </li>
        <li>
            <a href="#api-usage" class="text-[#8A2BE2] hover:underline text-lg">3. API Usage</a>
        </li>
        <li>
            <a href="#examples" class="text-[#8A2BE2] hover:underline text-lg">4. Examples</a>
        </li>
        <li>
            <a href="#conclusion" class="text-[#8A2BE2] hover:underline text-lg">5. Conclusion</a>
        </li>
    </ul>
</div>
  </body>
  </html>