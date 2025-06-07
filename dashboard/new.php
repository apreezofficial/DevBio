<?php
session_start();
include '../includes/settings.php';
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You have to login to access this feature.";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $current_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['redirect_url'] = $current_url;
    header('Location: login.php');
    exit;
}
if (isset($_COOKIE['user_id'])) {
  $_SESSION['user_id'] = $_COOKIE['user_id'];
  $_SESSION['email'] = $_COOKIE['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Generate Portfolio Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="/tailwind.js"></script>
  <link rel="stylesheet" href="./includes/font-awesome/css/all.css" />
  <link rel="stylesheet" href="./includes/css/animation.css" />
                  <script src="/includes/ts/theme.ts"></script>
  <script>
    tailwind.config = { darkMode: 'class' };
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism-okaidia.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-markdown.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-json.min.js"></script>
  <style>
    .loader-bounce {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 10px;
    }
    .dot {
      width: 10px;
      height: 10px;
      background-color: #6366F1;
      border-radius: 50%;
      animation: bounce 0.5s infinite alternate;
    }
    .dot:nth-child(2) { animation-delay: 0.1s; }
    .dot:nth-child(3) { animation-delay: 0.2s; }
    @keyframes bounce {
      to { transform: translateY(-10px); }
    }
  </style>
</head>
<body class="bg-white text-gray-900 dark:bg-[#0D0D0D] dark:text-white transition duration-300">
  <?php include '../includes/dashnav.php';?>

  <div class="max-w-2xl mx-auto mt-10 p-6 rounded-lg shadow-lg bg-gray-50 dark:bg-gray-900">
    <h1 class="text-2xl font-bold mb-4 text-center">🛠 Generate a Dev Portfolio</h1> 
<form id="newProjectForm" class="space-y-6">
  <input type="hidden" name="ajax" value="1" />

  <!-- General Instructions -->
  <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
      </svg>
      Instructions
    </h3>
    <ul class="text-sm text-blue-700 dark:text-blue-300 list-disc pl-5 space-y-1">
      <li>Fields marked with <span class="text-red-500">*</span> are  Required</li>
      <li>Click the + button to add multiple projects</li>
      <li>You can drag projects to reorder them</li>
      <li>Generated portfolio will include all added projects</li>
    </ul>
  </div>

  <!-- Developer Information Section -->
  <div class="border-b pb-6 mb-6">
    <h3 class="text-xl font-semibold mb-4 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
      </svg>
      Developer Information
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="dev_name" class="block font-medium mb-2">
          Developer Name <span class="text-red-500">*</span>
        </label>
        <input id="dev_name" name="dev_name" type="text"  
          class="w-full p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
      </div>

      <div>
        <label for="dev_email" class="block font-medium mb-2">
          Contact Email <span class="text-red-500">*</span>
        </label>
        <input id="dev_email" name="dev_email" type="email"  
          class="w-full p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
      </div>

      <div>
        <label for="tech_role" class="block font-medium mb-2">Developer Role <span class="text-red-500">*</span></label>
        <select id="tech_role" name="tech_role"  
          class="w-full p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          <option value="">Select your role</option>
          <option value="Frontend Developer">Frontend Developer</option>
          <option value="Backend Developer">Backend Developer</option>
          <option value="Fullstack Developer">Fullstack Developer</option>
          <option value="Azure Developer">Azure Developer</option>
          <option value="Web3 Developer">Web3 Developer</option>
          <option value="Mobile Developer">Mobile Developer</option>
        </select>
      </div>

      <div>
        <label for="avatar_url" class="block font-medium mb-2">Avatar URL</label>
        <div class="flex items-center space-x-3">
          <input id="avatar_url" name="avatar_url" type="url" 
            value="https://www.gravatar.com/avatar/default?s=200" 
            class="flex-1 p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
          <img id="avatar-preview" src="https://www.gravatar.com/avatar/default?s=200" class="w-12 h-12 rounded-full border-2 border-gray-300 dark:border-gray-600" alt="Avatar Preview">
        </div>
      </div>
    </div>
  </div>

  <!-- Tech Stack Section -->
  <div class="border-b pb-6 mb-6">
    <h3 class="text-xl font-semibold mb-4 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
      Portfolio Details
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="frontend_tech" class="block font-medium mb-2">Frontend Technology <span class="text-red-500">*</span></label>
        <select id="frontend_tech" name="frontend_tech"  
          class="w-full p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          <option value="">Select technology</option>
          <option value="HTML">HTML/CSS/JS</option>
          <option value="React">React</option>
          <option value="Vue">Vue</option>
          <option value="Angular">Angular</option>
          <option value="Svelte">Svelte</option>
        </select>
      </div>

      <div>
        <label for="styling" class="block font-medium mb-2">Styling Framework <span class="text-red-500">*</span></label>
        <select id="styling" name="styling"  
          class="w-full p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          <option value="">Select framework</option>
          <option value="CSS">Plain CSS</option>
          <option value="Tailwind">Tailwind CSS</option>
          <option value="Bootstrap">Bootstrap</option>
          <option value="DaisyUI">DaisyUI</option>
          <option value="Styled Components">Styled Components</option>
        </select>
      </div>

      <div class="md:col-span-2">
        <label for="additional_components" class="block font-medium mb-2">Additional Components</label>
        <select id="additional_components" name="additional_components" multiple
          class="w-full p-3 border rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          <option value="Framer Motion">Framer Motion</option>
          <option value="GSAP">GSAP</option>
          <option value="Three.js">Three.js</option>
          <option value="Chart.js">Chart.js</option>
          <option value="D3.js">D3.js</option>
        </select>
      </div>
    </div>
  </div>
<!-- Projects Section -->
<div id="projects-section">
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-xl font-semibold flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
      </svg>
      Projects
    </h3>
    <button type="button" id="add-project" class="flex items-center text-sm bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      Add Project
    </button>
  </div>

  <div id="projects-container" class="space-y-6">
    <!-- Projects will be added here dynamically -->
    <div class="project-item border border-gray-200 dark:border-gray-700 rounded-lg p-5 bg-white dark:bg-gray-800 shadow-sm" data-index="0">
      <div class="flex justify-between items-center mb-4">
        <h4 class="font-medium text-lg">Project #1</h4>
        <button type="button" class="remove-project text-red-500 hover:text-red-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block font-medium mb-2">Project Name <span class="text-red-500">*</span></label>
          <input type="text" name="projects[0][name]"  
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
        
        <div>
          <label class="block font-medium mb-2">Project URL</label>
          <input type="url" name="projects[0][url]"
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
        
        <div class="md:col-span-2">
          <label class="block font-medium mb-2">Description <span class="text-red-500">*</span></label>
          <textarea name="projects[0][description]" rows="3"  
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
        </div>
        
        <div>
          <label class="block font-medium mb-2">Image URL</label>
          <input type="url" name="projects[0][image]"
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
        
        <div>
          <label class="block font-medium mb-2">GitHub Repository</label>
          <input type="url" name="projects[0][github]"
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const projectsContainer = document.getElementById('projects-container');
  let projectCount = 1; // Start from 1 since we have one by default

  // Add project
  document.getElementById('add-project').addEventListener('click', function() {
    const newIndex = projectCount++;
    const newProject = document.createElement('div');
    newProject.className = 'project-item border border-gray-200 dark:border-gray-700 rounded-lg p-5 bg-white dark:bg-gray-800 shadow-sm';
    newProject.dataset.index = newIndex;
    
    newProject.innerHTML = `
      <div class="flex justify-between items-center mb-4">
        <h4 class="font-medium text-lg">Project #${newIndex + 1}</h4>
        <button type="button" class="remove-project text-red-500 hover:text-red-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block font-medium mb-2">Project Name <span class="text-red-500">*</span></label>
          <input type="text" name="projects[${newIndex}][name]"  
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
        
        <div>
          <label class="block font-medium mb-2">Project URL</label>
          <input type="url" name="projects[${newIndex}][url]"
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
        
        <div class="md:col-span-2">
          <label class="block font-medium mb-2">Description <span class="text-red-500">*</span></label>
          <textarea name="projects[${newIndex}][description]" rows="3"  
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
        </div>
        
        <div>
          <label class="block font-medium mb-2">Image URL</label>
          <input type="url" name="projects[${newIndex}][image]"
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
        
        <div>
          <label class="block font-medium mb-2">GitHub Repository</label>
          <input type="url" name="projects[${newIndex}][github]"
            class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        </div>
      </div>
    `;
    
    projectsContainer.appendChild(newProject);
  });

  // Remove project (delegate to container)
  projectsContainer.addEventListener('click', function(e) {
    if (e.target.closest('.remove-project')) {
      const projectItem = e.target.closest('.project-item');
      if (document.querySelectorAll('.project-item').length > 1) {
        projectItem.remove();
        reindexProjects();
      } else {
        alert('You must have at least one project');
      }
    }
  });

  // Reindex projects after deletion
  function reindexProjects() {
    const projects = document.querySelectorAll('.project-item');
    projects.forEach((project, index) => {
      project.dataset.index = index;
      project.querySelector('h4').textContent = `Project #${index + 1}`;
      
      // Update all input names
      const inputs = project.querySelectorAll('input, textarea');
      inputs.forEach(input => {
        const name = input.name.replace(/projects\[\d+\]/, `projects[${index}]`);
        input.name = name;
      });
    });
    projectCount = projects.length;
  }
});

// Form submission handling
document.getElementById('yourFormId').addEventListener('submit', async function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  
  try {
    const response = await fetch('your-php-endpoint.php', {
      method: 'POST',
      body: formData
    });
    
    const data = await response.json();
    
    if (data.status === 'success') {
      alert('Projects saved successfully!');
      // Handle success (e.g., redirect or show message)
    } else {
      alert('Error: ' + (data.message || 'Failed to save projects'));
    }
  } catch (error) {
    alert('Network error: ' + error.message);
  }
});
</script>

  <!-- Submit Button -->
  <div class="text-right pt-6">
    <button type="submit" 
      class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition font-medium text-lg flex items-center justify-center space-x-2" id="genbtn">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M6.672 1.911a1 1 0 10-1.932.518l.259.966a1 1 0 001.932-.518l-.26-.966zM2.429 4.74a1 1 0 10-.517 1.932l.966.259a1 1 0 00.517-1.932l-.966-.26zm8.814-.569a1 1 0 00-1.415-1.414l-.707.707a1 1 0 101.415 1.415l.707-.708zm-7.071 7.072l.707-.707A1 1 0 003.465 9.12l-.708.707a1 1 0 001.415 1.415zm3.2-5.171a1 1 0 00-1.3 1.3l4 10a1 1 0 001.823.075l1.38-2.759 3.018 3.02a1 1 0 001.414-1.415l-3.019-3.02 2.76-1.379a1 1 0 00-.076-1.822l-10-4z" clip-rule="evenodd" />
      </svg>
      <span>Generate Portfolio</span>
    </button>
  </div>
</form>

<!-- Include multi-select and drag/drop libraries -->
<link href="https://cdn.jsdelivr.net/npm/multi-select-tag@2.0.0/dist/css/multi-select-tag.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/multi-select-tag@2.0.0/dist/js/multi-select-tag.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
  <div id="loader" class="hidden text-center mt-6">
      <div class="loader-bounce">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
      <p class="text-indigo-600 dark:text-indigo-400 mt-2 font-semibold">Generating...</p>
    </div>

    <div id="result" class="mt-6 space-y-6 hidden"></div>
  </div>
<script>
document.getElementById('newProjectForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    const resultContainer = document.getElementById('result');
    const loader = document.getElementById('loader');
const genbtn = document.getElementById('genbtn');

    resultContainer.classList.add('hidden');
    loader.classList.remove('hidden');
    resultContainer.innerHTML = '';
    genbtn.innerHTML='Generating...';
    genbtn.classList.add('disabled');
    try {
        const res = await fetch('petty.php', {
            method: 'POST',
            body: formData
        });
setTimeout(() => {
      window.scrollTo({
        top: document.body.scrollHeight,
        behavior: "smooth"
      });
    }, 100);
        const data = await res.json();
        loader.classList.add('hidden');
       genbtn.innerHTML=' 🚀 Generate Portfolio';
    genbtn.classList.remove('disabled');
        if (data.status === 'success') {
            const zip = new JSZip(); // Init ZIP
            resultContainer.innerHTML = '';

            data.files.forEach(file => {
                const block = document.createElement('div');
                block.className = 'relative bg-white dark:bg-[#0D0D0D] border border-gray-300 dark:border-gray-700 rounded-xl p-4 my-4 shadow-md';

                const title = document.createElement('h3');
                title.textContent = `📁 ${file.filename}`;
                title.className = 'font-semibold text-[#FF6B00] dark:text-[#8A2BE2] text-lg mb-2';

                const copyBtn = document.createElement('button');
                copyBtn.textContent = 'Copy code';
                copyBtn.type = 'button';
                copyBtn.className = `
                    absolute top-3 right-3 px-3 py-1 rounded 
                    bg-[#FF6B00] hover:bg-[#e55d00] 
                    dark:bg-[#8A2BE2] dark:hover:bg-[#7320bd] 
                    text-white text-xs font-medium transition
                `;

                const codeBlock = document.createElement('pre');
                codeBlock.className = 'rounded overflow-auto';

                const codeElem = document.createElement('code');
                codeElem.className = (() => {
                    if (file.filename.endsWith('.js') || file.filename.endsWith('.jsx')) return 'language-javascript';
                    if (file.filename.endsWith('.php')) return 'language-php';
                    if (file.filename.endsWith('.css')) return 'language-css';
                    if (file.filename.endsWith('.json')) return 'language-json';
                    if (file.filename.endsWith('.py')) return 'language-python';
                    if (file.filename.endsWith('.md')) return 'language-markdown';
                    return 'language-markup';
                })();
                codeElem.textContent = file.code;

                codeBlock.appendChild(codeElem);
                block.appendChild(title);
                block.appendChild(copyBtn);
                block.appendChild(codeBlock);
                resultContainer.appendChild(block);

                // 🧠 Highlight
                setTimeout(() => Prism.highlightElement(codeElem), 0);

                // 📋 Copy functionality
                copyBtn.addEventListener('click', () => {
                    navigator.clipboard.writeText(file.code).then(() => {
                        copyBtn.textContent = 'Copied!';
                        setTimeout(() => copyBtn.textContent = 'Copy code', 2000);
                    }).catch(() => {
                        copyBtn.textContent = 'Failed to copy';
                        setTimeout(() => copyBtn.textContent = 'Copy code', 2000);
                    });
                });

                // Add to ZIP
                zip.file(file.filename, file.code);

                // DB insert
                fetch('dbgenerate.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ filename: file.filename, code: file.code })
                }).catch(err => {
                    console.warn('DB insert failed:', err.message);
                });
            });

            // ZIP Button
            const zipBtn = document.createElement('button');
            zipBtn.textContent = '⬇️ Download All as ZIP';
            zipBtn.className = `
                mt-6 px-6 py-3 rounded-xl font-semibold text-white 
                bg-[#FF6B00] hover:bg-[#e55d00] 
                dark:bg-[#8A2BE2] dark:hover:bg-[#7320bd] 
                transition duration-300 ease-in-out shadow-md
            `;
            zipBtn.addEventListener('click', () => {
                zip.generateAsync({ type: 'blob' }).then(content => {
                    saveAs(content, 'devbioproject.zip');
                });
            });

            resultContainer.appendChild(zipBtn);
            resultContainer.classList.remove('hidden');

        } else {
            resultContainer.textContent = data.message || 'Something went wrong.';
            resultContainer.className = 'mt-6 p-4 rounded bg-red-100 text-red-900 dark:bg-red-900 dark:text-red-100';
            resultContainer.classList.remove('hidden');
        }

    } catch (error) {
        loader.classList.add('hidden');
        resultContainer.textContent = 'Fetch error: ' + error.message;
        resultContainer.className = 'mt-6 p-4 rounded bg-red-100 text-red-900 dark:bg-red-900 dark:text-red-100';
        resultContainer.classList.remove('hidden');
    }
});
</script>
</body>
</html>
