<?php 
include 'nav.php';
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo $dark_mode ? 'dark' : ''; ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo $app_name; ?> By Precious</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./font-awesome/css/all.css">
    <script src="/tailwind.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: { light: '#3b82f6', dark: '#2563eb' },
            secondary: { light: '#10b981', dark: '#059669' }
          }
        }
      }
    }
  </script>
  <style>
  :root {
    --swal-bg-light: #f8f9fa;
    --swal-text-light: #343a40;
    --swal-icon-light: #dc3545;
    --swal-progress-light: #dc3545;
    
    --swal-bg-dark: #2d3748;
    --swal-text-dark: #f8f9fa;
    --swal-icon-dark: #f56565;
    --swal-progress-dark: #f56565;
}

.dark {
    --swal-bg: var(--swal-bg-dark);
    --swal-text: var(--swal-text-dark);
    --swal-icon: var(--swal-icon-dark);
    --swal-progress: var(--swal-progress-dark);
}

:root:not(.dark) {
    --swal-bg: var(--swal-bg-light);
    --swal-text: var(--swal-text-light);
    --swal-icon: var(--swal-icon-light);
    --swal-progress: var(--swal-progress-light);
}
    .word-card { transition: all 0.3s ease; }
    .word-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    .dark .word-card:hover { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3); }
    #suggestions { max-height: 200px; overflow-y: auto; }
  </style>
</head>
<?php include 'main.php';?>
  <style>
    @keyframes shimmer {
      0% { opacity: 0.5; }
      50% { opacity: 1; }
      100% { opacity: 0.5; }
    }
    
    .shimmer {
      animation: shimmer 10s infinite ease-in-out;
    }
  </style>
  <?php include 'footer.php';?>
  <?php include 'script.php'; ?>
</html>