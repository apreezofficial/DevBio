<?php
require 'includes/settings.php';
?>


<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <!-- Essential Meta Tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="google-site-verification" content="mpfvExLjgj2MPsncOhhRIMSpfFm-zw9WJNEGflQNONU" />

  <!-- Title & Description -->
  <title><?php echo $appName;?> | The Lead Portfolio Generator </title>
  <meta name="title" content="<?php echo $appName;?> - The Lead Portfolio Generator" />
  <meta name="description" content="<?php echo $appName;?> is a leading portfolio generator delivering fast, secure, and scalable protfolio for techies. Crafted by expert developer Precious Adedokun." />
  <!-- SEO Keywords -->
  <meta name="keywords" content="<?php echo $appName;?>, Full Stack Developer, App Developer, Web Development Company Nigeria, Scalable Web Apps, Secure APIs, UI/UX Design, Software Solutions, Tech Innovation, Precious Adedokun" />
  <meta name="author" content="Precious Adedokun" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="" />
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="" />
  <meta property="og:title" content="<?php echo $appName;?> | Innovative Full Stack & App Development Solutions" />
  <meta property="og:description" content="<?php echo $appName;?> builds powerful, secure, and scalable digital solutions. Developed by expert Precious Adedokun, our team delivers excellence in web and app development." />
  <meta property="og:image" content="/assets/logo.png" />

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="" />
  <meta name="twitter:title" content="<?php echo $appName;?> | Innovative Full Stack & App Development Solutions" />
  <meta name="twitter:description" content="Explore <?php echo $appName;?>'s cutting-edge web and app development solutions, crafted by expert developer Precious Adedokun." />
  <meta name="twitter:image" content="/assets/logo.png" />

  <!-- Theme & Favicon -->
  <meta name="theme-color" content="#2563eb" />
  <link rel="icon" type="image/png" href="/assets/logo.png" />
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "<?php echo $appName;?>",
    "url": "",
    "logo": "/includes/images/logo.png"",
    "sameAs": [
      "https://github.com/apreezofficial",
      "https://x.com/apcodesphere",
      "https://tiktok.com/@apcodesphere",
      "https://instagram.com/apcodesphere"
    ],
    "founder": {
      "@type": "Person",
      "name": "Precious Adedokun"
    },
    "description": "<?php echo $appName;?> is a technology company specializing in fast, secure, and scalable full stack and app development solutions."
  }
  </script>
    <script src="tailwind.js"></script>
      <link rel="stylesheet" href="./includes/font-awesome/css/all.css">
            <link rel="stylesheet" href="./includes/css/animation.css">
  <script>
  tailwind.config = { darkMode: 'class' }
</script>
</head>
<body class="bg-white text-black dark:bg-black dark:text-white transition-colors duration-300">

  <?php include('includes/nav.php'); ?>

  <main class="pt-20 px-4">
    <!--Hero Section-->
<section class="min-h-screen bg-white dark:bg-zinc-950 flex items-center justify-center px-6 sm:px-10">
  <div class="max-w-4xl w-full text-center space-y-6">
    <!-- Tagline -->
    <p class="text-sm font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider animate-fadeInUp">
      Build Your Dev Portfolio Smarter
    </p>

    <!-- Headline -->
    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-zinc-900 dark:text-white animate-fadeInUp delay-100">
      Generate <span class="text-indigo-600 dark:text-indigo-400">Dev Portfolios</span> with Ease.
    </h1>

    <!-- Subheading -->
    <p class="mt-4 text-lg sm:text-xl text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto animate-fadeInUp delay-200">
      Say goodbye to boring setups. Create beautiful, modern developer bios and portfolios with a few clicks.
    </p>

    <!-- CTA Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4 animate-fadeInUp delay-300">
      <a href="/dashboard/new.php" class="px-6 py-3 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-lg dark:shadow-indigo-500/30">
        Generate Now
      </a>
      <a href="/docs" class="px-6 py-3 rounded-xl text-indigo-600 bg-indigo-100 hover:bg-indigo-200 transition dark:text-indigo-300 dark:bg-zinc-800 dark:hover:bg-zinc-700">
        View Docs
      </a>
    </div>
  </div>
</section>
    <!--Stats Section-->
<section class="relative py-24 bg-gradient-to-br from-white to-zinc-100 dark:from-zinc-950 dark:to-zinc-900 overflow-hidden" id="stats">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h2 class="text-4xl sm:text-5xl font-bold text-zinc-800 dark:text-white mb-16 animate__animated animate__fadeInUp">
      Trusted by Devs <span class="text-indigo-600">Worldwide</span>
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-10 animate__animated animate__zoomIn">
      <div class="space-y-2">
        <div class="text-4xl font-bold text-indigo-600"><span class="counter" data-target="5"></span>k+</div>
        <p class="text-zinc-600 dark:text-zinc-300 text-sm">Downloads</p>
      </div>

      <div class="space-y-2">
        <div class="text-4xl font-bold text-indigo-600"><span class="counter" data-target="60"></span>+</div>
        <p class="text-zinc-600 dark:text-zinc-300 text-sm">Countries</p>
      </div>

      <div class="space-y-2">
        <div class="text-4xl font-bold text-indigo-600"><span class="counter" data-target="99.9"></span>%</div>
        <p class="text-zinc-600 dark:text-zinc-300 text-sm">Uptime</p>
      </div>

      <div class="space-y-2">
        <div class="text-4xl font-bold text-indigo-600">∞</div>
        <p class="text-zinc-600 dark:text-zinc-300 text-sm">Customization</p>
      </div>
    </div>
  </div>
</section>
    <!--Why Section-->
<section class="py-20 bg-white dark:bg-zinc-950 px-6 sm:px-10 overflow-hidden">
  <div class="max-w-6xl mx-auto text-center">
    <!-- Header -->
    <h2 class="text-3xl sm:text-4xl font-extrabold text-zinc-900 dark:text-white mb-4 animate-slideUp">
      Why <span class="text-indigo-600 dark:text-indigo-400"><?php echo $appName;?></span>?
    </h2>
    <p class="text-zinc-600 dark:text-zinc-400 text-lg mb-12 max-w-2xl mx-auto animate-slideUp delay-100">
      We built <?php echo $appName;?> to make creating your portfolio as easy as writing your name. Fast, clean, developer-centric.
    </p>

    <!-- Feature Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 animate-slideUp delay-200">
      <!-- Feature 1 -->
      <div class="bg-zinc-100 dark:bg-zinc-900 p-6 rounded-2xl shadow-lg transition hover:scale-105 duration-300">
        <div class="text-indigo-600 dark:text-indigo-400 text-3xl mb-4">
          <i class="fas fa-bolt"></i>
        </div>
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white mb-2">Instant Generation</h3>
        <p class="text-zinc-600 dark:text-zinc-400 text-sm">Type your details, click generate — boom! Your portfolio is ready in seconds.</p>
      </div>

      <!-- Feature 2 -->
      <div class="bg-zinc-100 dark:bg-zinc-900 p-6 rounded-2xl shadow-lg transition hover:scale-105 duration-300">
        <div class="text-indigo-600 dark:text-indigo-400 text-3xl mb-4">
          <i class="fas fa-paint-brush"></i>
        </div>
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white mb-2">Tailwind Styled</h3>
        <p class="text-zinc-600 dark:text-zinc-400 text-sm">Clean, modern design powered by TailwindCSS — 100% responsive and customizable.</p>
      </div>

      <!-- Feature 3 -->
      <div class="bg-zinc-100 dark:bg-zinc-900 p-6 rounded-2xl shadow-lg transition hover:scale-105 duration-300">
        <div class="text-indigo-600 dark:text-indigo-400 text-3xl mb-4">
          <i class="fas fa-cloud-download-alt"></i>
        </div>
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white mb-2">Downloadable HTML</h3>
        <p class="text-zinc-600 dark:text-zinc-400 text-sm">Export your generated portfolio instantly — ready to host anywhere.</p>
      </div>
    </div>
  </div>
</section>
    <!--Testimonials Section-->
<section class="py-20 bg-zinc-50 dark:bg-zinc-900 px-6 sm:px-10">
  <div class="max-w-5xl mx-auto text-center">
    <h2 class="text-3xl font-extrabold text-zinc-900 dark:text-white mb-8 animate-fadeInDown">
      What <span class="text-indigo-600 dark:text-indigo-400"><?php echo $appName;?></span> Users Say
    </h2>

    <!-- Carousel container -->
    <div id="testimonial-carousel" class="relative overflow-hidden rounded-xl bg-white dark:bg-zinc-800 shadow-lg p-10 max-w-3xl mx-auto animate-fadeInUp">
      
      <!-- Testimonial Items -->
      <div class="testimonial-item opacity-100 transition-opacity duration-700">
        <p class="text-zinc-700 dark:text-zinc-300 italic mb-6">"<?php echo $appName;?> made building my portfolio effortless. The generated design looks professional and loads lightning fast!"</p>
        <h3 class="text-indigo-600 font-semibold">— Treasure Uzoma, FullStack Dev</h3>
      </div>

      <div class="testimonial-item opacity-0 absolute top-10 left-0 right-0 transition-opacity duration-700 pointer-events-none">
        <p class="text-zinc-700 dark:text-zinc-300 italic mb-6">"I love how customizable it is! Tailwind integration is a blessing for quick styling tweaks."</p>
        <h3 class="text-indigo-600 font-semibold">— Robisson Honour, Fullstack Engineer</h3>
      </div>

      <div class="testimonial-item opacity-0 absolute top-10 left-0 right-0 transition-opacity duration-700 pointer-events-none">
        <p class="text-zinc-700 dark:text-zinc-300 italic mb-6">"Perfect for busy developers — easy, clean, and fast portfolio creation!"</p>
        <h3 class="text-indigo-600 font-semibold">— Ptech, Web3 Developer</h3>
      </div>

      <!-- Controls -->
      <div class="flex justify-center space-x-4 mt-8">
        <button class="testimonial-dot w-3 h-3 rounded-full bg-indigo-600 dark:bg-indigo-400 opacity-100" aria-label="Show testimonial 1"></button>
        <button class="testimonial-dot w-3 h-3 rounded-full bg-indigo-600 dark:bg-indigo-400 opacity-40" aria-label="Show testimonial 2"></button>
        <button class="testimonial-dot w-3 h-3 rounded-full bg-indigo-600 dark:bg-indigo-400 opacity-40" aria-label="Show testimonial 3"></button>
      </div>
    </div>
  </div>
</section>
    <!--faq Section-->
<section class="bg-white dark:bg-zinc-900 py-20 px-6 transition-colors duration-500">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-center text-zinc-900 dark:text-white mb-12">Frequently Asked Questions</h2>
    
    <div id="faq-container" class="space-y-4">
      <!-- FAQ Item 1 -->
      <div class="border border-zinc-300 dark:border-zinc-700 rounded-lg overflow-hidden transition-all">
        <button class="w-full text-left px-6 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-medium flex items-center justify-between faq-question transition hover:bg-zinc-200 dark:hover:bg-zinc-700">
          What is <?php echo $appName;?> and who is it for?
          <span class="faq-icon transition-transform">&#x25BC;</span>
        </button>
        <div class="faq-answer max-h-0 overflow-hidden bg-zinc-50 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 px-6 transition-all duration-500">
          <p class="py-4"><?php echo $appName;?> is a powerful portfolio generator designed for developers of all levels. Whether you’re new or experienced, you’ll find it intuitive and customizable.</p>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div class="border border-zinc-300 dark:border-zinc-700 rounded-lg overflow-hidden transition-all">
        <button class="w-full text-left px-6 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-medium flex items-center justify-between faq-question transition hover:bg-zinc-200 dark:hover:bg-zinc-700">
          Can I export my portfolio to host it anywhere?
          <span class="faq-icon transition-transform">&#x25BC;</span>
        </button>
        <div class="faq-answer max-h-0 overflow-hidden bg-zinc-50 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 px-6 transition-all duration-500">
          <p class="py-4">Yes, your generated portfolio is yours. You can download it and host it on any platform including Vercel, Netlify, GitHub Pages, or your own server.</p>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div class="border border-zinc-300 dark:border-zinc-700 rounded-lg overflow-hidden transition-all">
        <button class="w-full text-left px-6 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-medium flex items-center justify-between faq-question transition hover:bg-zinc-200 dark:hover:bg-zinc-700">
          Will there be more features added?
          <span class="faq-icon transition-transform">&#x25BC;</span>
        </button>
        <div class="faq-answer max-h-0 overflow-hidden bg-zinc-50 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 px-6 transition-all duration-500">
          <p class="py-4">Absolutely! We’re continuously adding new templates, integrations, and customization tools based on community feedback.</p>
        </div>
      </div>
    </div>
  </div>
</section>
    <!--cta Section-->
<section class="bg-gradient-to-r from-indigo-700 via-indigo-900 to-blue-800 text-white py-20 px-6">
  <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
    
    <div class="max-w-xl text-center md:text-left animate-fadeInLeft">
      <h2 class="text-4xl font-extrabold leading-tight mb-4 tracking-tight drop-shadow-md">
        Ready to Build Your Developer Portfolio?
      </h2>
      <p class="text-indigo-200 text-lg mb-6">
        Generate a sleek, personalized portfolio in seconds. Stand out and showcase your skills with <?php echo $appName;?>.
      </p>
    </div>

    <div class="flex gap-6">
      <a href="/dashboard/register.php" 
         class="bg-white text-indigo-900 font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-indigo-500/60 transition-shadow duration-300 animate-fadeInUp">
        Get Started
      </a>
      <a href="/docs/" 
         class="border border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-indigo-900 transition-colors duration-300 animate-fadeInUp delay-150">
        Learn More
      </a>
    </div>
  </div>
</section>
    <!--subscribe Section-->
<section class="bg-white dark:bg-[#0D0D0D] py-20 px-6 text-gray-900 dark:text-white transition-colors duration-500">
  <div class="max-w-3xl mx-auto text-center">
    <h2 class="text-4xl font-extrabold tracking-tight mb-4 animate-fadeInDown">
      Join the <span class="text-indigo-600 dark:text-indigo-400"><?php echo htmlspecialchars($appName); ?></span> Insider List
    </h2>
    <p class="text-gray-600 dark:text-indigo-300 text-lg leading-relaxed mb-10 animate-fadeInDown delay-150">
      Get exclusive updates, tutorials, and early access to new features. Let’s build your portfolio journey together!
    </p>

<form method="POST" id="subscribeForm" novalidate
  class="mx-auto animate-fadeInUp delay-300 max-w-lg px-4 sm:px-0"
>
  <div class="flex flex-col sm:flex-row items-center gap-4 relative">
    <div class="flex-1 w-full relative">
      <input
        type="email"
        id="email"
        name="email"
        required
        placeholder="Your email address"
        aria-describedby="subscribeMessage"
        class="peer w-full rounded-full bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-transparent px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-base sm:text-lg"
      />
      <label
        for="email"
        class="absolute left-6 top-1/2 -translate-y-1/2 text-indigo-600 dark:text-indigo-300 text-sm sm:text-base transition-all
               peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-indigo-400
               peer-focus:top-4 peer-focus:text-sm peer-focus:text-indigo-400 cursor-text select-none"
      >
        Your email address
      </label>
    </div>

    <button
      type="submit"
      id="subscribeButton"
      class="bg-indigo-600 hover:bg-indigo-500 font-bold text-white rounded-full px-8 py-3 shadow-xl focus:ring-4 focus:ring-indigo-400
             w-full sm:w-auto text-base sm:text-lg transition-transform hover:scale-105 animate-pulse"
    >
      Subscribe
    </button>
  </div>
</form>

    <p id="subscribeMessage" class="mt-3 text-xs hidden text-gray-500 dark:text-gray-400 min-h-[1.5rem]" role="alert" aria-live="polite"></p>

    <p class="mt-8 text-sm text-gray-500 dark:text-indigo-400 animate-fadeInUp delay-500">
      No spam. Unsubscribe anytime.
    </p>
  </div>
</section>
    <!--Contact Section-->
<section id="contact" class="py-12 px-6 bg-white dark:bg-zinc-900 transition-colors duration-500">
  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">

    <!-- Left Info Panel -->
    <div class="space-y-6">
    <h2 class="text-3xl sm:text-4xl font-extrabold text-zinc-900 dark:text-white mb-4 animate-slideUp">
      Contact <span class="text-indigo-600 dark:text-indigo-400"><?php echo $appName;?></span>
    </h2>
      <p class="text-lg text-zinc-600 dark:text-zinc-300 animate-fadeInUp delay-100 max-w-xl">
        For inquiries about our services, partnerships, or support, please reach out to our team. We are committed to assisting you promptly and professionally.
      </p>

      <div class="space-y-5 text-zinc-700 dark:text-zinc-300">
        <div class="flex items-center gap-4">
          <i class="fas fa-envelope text-blue-600 dark:text-blue-400 text-xl animate-pulse"></i>
          <a href="apreezofficial@gmail.com" class="hover:underline">apreezofficial@gmail.com</a>
        </div>
        <div class="flex items-center gap-4">
          <i class="fas fa-phone text-blue-600 dark:text-blue-400 text-xl animate-pulse"></i>
          <a href="tel:++2349064779856" class="hover:underline">+234 906 477 9856</a>
        </div>
        <div class="flex items-center gap-4">
          <i class="fa fa-location-dot text-blue-600 dark:text-blue-400 text-xl animate-pulse"></i>
          <address class="not-italic">E12, Unitu Avenue, Ado-Ekiti, Ekiti State</address>
        </div>
      </div>
    </div>
<form
  id="contactForm"
  class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl shadow-2xl p-10 space-y-6 animate-slideUp transition duration-300 bounce-up"
  method="POST"
  novalidate
>
  <div>
    <label for="name" class="block text-zinc-700 dark:text-zinc-200 mb-1 font-semibold">Full Name</label>
    <input
      type="text"
      id="name"
      name="name"
      required
      placeholder="Your full name"
      class="w-full px-5 py-4 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
    />
  </div>

  <div>
    <label for="email" class="block text-zinc-700 dark:text-zinc-200 mb-1 font-semibold">Email Address</label>
    <input
      type="email"
      id="email"
      name="email"
      required
      placeholder="your.email@example.com"
      class="w-full px-5 py-4 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
    />
  </div>

  <div>
    <label for="message" class="block text-zinc-700 dark:text-zinc-200 mb-1 font-semibold">Message</label>
    <textarea
      id="message"
      name="message"
      rows="6"
      required
      placeholder="Write your message here"
      class="w-full px-5 py-4 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition resize-none"
    ></textarea>
  </div>

  <button
    type="submit"
    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-lg font-semibold py-4 rounded-xl shadow-md transition-transform hover:scale-105 active:scale-95"
  >
    Submit Inquiry
  </button>

  <p id="formMessage" class="mt-4 text-center text-sm"></p>
</form>
  </div>
</section>
  </main>
    <script src="/includes/js/slider.js"></script>
        <script src="/includes/js/contact.js"></script>
        <script src="/includes/js/subscribe.js"></script>
        <script src="/includes/js/faq.js"></script>
                <script src="/includes/js/counter.js"></script>
  <script src="/includes/js/theme.js"></script>
                <script src="/includes/js/headertext.js"></script>
  <script src="/includes/js/movingcds.js"></script>
</body>
</html>
<?php
include './includes/footer.php';
?>
        <style>
  @keyframes slide {
    0% { transform: translateX(0%); }
    100% { transform: translateX(-50%); }
  }

  .animate-slide {
    animation: slide 10s linear infinite;
    display: flex;
    min-width: max-content;
  }
</style>