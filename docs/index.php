  <?php include '../includes/settings.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Docs</title>
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
<div class="bg-white dark:bg-[#0D0D0D] p-6 border-l-4 border-[#8A2BE2] rounded-2xl shadow-md mb-8">
    <h2 class="text-2xl font-bold text-black dark:text-[#EAEAEA] mb-4 flex items-center gap-2">
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

<!-- Introduction Section -->
<section id="introduction" class="bg-white dark:bg-[#0D0D0D] p-6 border-l-4 border-[#FF6B00] rounded-2xl shadow-md mb-8 scroll-mt-24">
    <h2 class="text-3xl font-bold text-black dark:text-[#EAEAEA] mb-4 flex items-center gap-2">
        ✨ Introduction
    </h2>
    <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
        Welcome to the <span class="text-[#8A2BE2] font-semibold">DevBio Documentation</span> — your go-to guide for exploring the powerful features, API usage, and best practices.
        This documentation will help you quickly understand how to set up, navigate, and integrate DevBio into your projects effortlessly.
    </p>
</section>
<!-- Setup Section -->
<section id="setup" class="bg-white dark:bg-[#0D0D0D] p-6 border-l-4 border-[#8A2BE2] rounded-2xl shadow-md mb-8 scroll-mt-24">
    <h2 class="text-3xl font-bold text-black dark:text-[#EAEAEA] mb-4 flex items-center gap-2">
        ⚙️ Setup
    </h2>
    
    <!-- Authentication Setup -->
    <div class="mb-6">
        <h3 class="text-2xl font-semibold text-black dark:text-[#EAEAEA] mb-2">1. User Registration</h3>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mb-4">
            Users can register using their email address. Upon registration, a unique verification code and a verification link will be sent to the provided email. 
            The user can choose to verify using either the code or the link. 
            <span class="text-[#FF6B00] font-semibold">Note:</span> The verification code is valid for <span class="text-[#8A2BE2] font-semibold">10 minutes</span>.
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
            Alternatively, users can sign up using <span class="text-[#8A2BE2] font-semibold">Google</span> or <span class="text-[#8A2BE2] font-semibold">GitHub</span> authentication for quicker access.
        </p>
    </div>

    <!-- Portfolio Setup -->
    <div class="mb-6">
        <h3 class="text-2xl font-semibold text-black dark:text-[#EAEAEA] mb-2">2. Portfolio Setup</h3>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mb-4">
            After successful authentication, users will be prompted to enter their personal and project details to generate their portfolio.
            The system will instantly build a custom portfolio structure.
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mb-4">
            Users can:
            <ul class="list-disc list-inside text-[#333333] dark:text-[#A1A1A1] space-y-2 mt-2">
                <li>Copy the code for each file individually.</li>
                <li>Download the entire project as a <span class="text-[#8A2BE2] font-semibold">ZIP file</span>.</li>
            </ul>
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
            Detailed instructions for setting up and running the portfolio are provided in the <span class="text-[#8A2BE2] font-semibold">README</span> file.
        </p>
    </div>

    <!-- ReadMe Generator -->
    <div class="mb-6">
        <h3 class="text-2xl font-semibold text-black dark:text-[#EAEAEA] mb-2">3. README Generation</h3>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
            To create a professional and detailed README file, use the integrated <span class="text-[#8A2BE2] font-semibold">Dokungen ReadMe Generator</span>.
            This tool will automatically generate a solid README based on your project information.
        </p>
    </div>
    <!-- Resume Setup -->
    <div>
        <h3 class="text-2xl font-semibold text-black dark:text-[#EAEAEA] mb-2">4. Resume Setup</h3>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
            Users can easily build their resume within the platform. Simply input your professional details into the resume builder, and the system will automatically generate a well-structured resume for you.
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mt-2">
            You can preview, copy, or download your resume in the provided formats.
        </p>
    </div>
</section>
<!-- API Usage Section -->
<section id="api-usage" class="bg-white dark:bg-[#0D0D0D] p-6 border-l-4 border-[#FF6B00] rounded-2xl shadow-md mb-8 scroll-mt-24">
    <h2 class="text-3xl font-bold text-black dark:text-[#EAEAEA] mb-4 flex items-center gap-2">
        🚀 API Usage
    </h2>

    <!-- Portfolio API -->
    <div class="mb-6">
        <h3 class="text-2xl font-semibold text-black dark:text-[#EAEAEA] mb-2">1. Portfolio Generation</h3>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mb-4">
            Portfolios can be generated <span class="text-[#8A2BE2] font-semibold">unlimited times</span> by authenticated users. After inputting project and personal details, the system will generate the portfolio structure instantly.
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
            Users can:
            <ul class="list-disc list-inside text-[#333333] dark:text-[#A1A1A1] space-y-2 mt-2">
                <li>Copy individual files.</li>
                <li>Download the full project as a ZIP file.</li>
            </ul>
        </p>
    </div>

    <!-- Resume API -->
    <div class="mb-6">
        <h3 class="text-2xl font-semibold text-black dark:text-[#EAEAEA] mb-2">2. Resume Generation</h3>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mb-4">
            Resume generation is limited to <span class="text-[#FF6B00] font-semibold">once per day</span> and a maximum of <span class="text-[#FF6B00] font-semibold">10 times per month</span> for free users.
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed mb-4">
            Once generated, resumes can be:
            <ul class="list-disc list-inside text-[#333333] dark:text-[#A1A1A1] space-y-2 mt-2">
                <li>Copied directly.</li>
                <li>Downloaded in <span class="text-[#8A2BE2] font-semibold">PDF</span>, <span class="text-[#8A2BE2] font-semibold">TXT</span>, or <span class="text-[#8A2BE2] font-semibold">Markdown (MD)</span> formats.</li>
                <li>Generated as a unique shareable link.</li>
            </ul>
        </p>
        <p class="text-[#333333] dark:text-[#A1A1A1] text-lg leading-relaxed">
            Free users can manage and track their usage limits directly from their dashboard.
        </p>
    </div>

    <!-- Additional Note -->
    <div class="bg-gray-100 dark:bg-[#1A1A1A] p-4 rounded-xl mt-6">
        <p class="text-black dark:text-[#EAEAEA] text-lg leading-relaxed">
            <span class="text-[#FF6B00] font-semibold">Important:</span> For resume generation, if daily or monthly limits are exceeded, users can upgrade to a premium plan to unlock unlimited access.
        </p>
    </div>
</section>
  </body>
  </html>