<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Resume Generator - APCodeSphere</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="/tailwind.js"></script>
  <link rel="stylesheet" href="../includes/font-awesome/css/all.css" />
  <link rel="stylesheet" href="../includes/css/animation.css" />
</head>
<style>
  @keyframes shake {
  0% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
  100% { transform: translateX(0); }
}

.shake {
  animation: shake 0.5s ease;
}

.border-red-500 {
  border-color: #f87171 !important; /* Tailwind's red-500 */
}
</style>
  <script>
  tailwind.config = { darkMode: 'class' }
</script>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white">
<div class="max-w-3xl mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
  <h2 class="text-2xl font-bold text-center text-blue-600 dark:text-purple-400 mb-6">Resume Builder</h2>

  <form id="resumeForm" method="POST">
<!-- Step Indicator -->
<div class="flex flex-wrap justify-between gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
  <span class="step flex items-center gap-1">
    <i class="fas fa-user"></i> <span class="hidden sm:inline">1. Bio</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-envelope"></i> <span class="hidden sm:inline">2. Contact</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-align-left"></i> <span class="hidden sm:inline">3. Summary</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-graduation-cap"></i> <span class="hidden sm:inline">4. Education</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-briefcase"></i> <span class="hidden sm:inline">5. Work</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-code"></i> <span class="hidden sm:inline">6. Projects</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-tools"></i> <span class="hidden sm:inline">7. Skills</span>
  </span>
  <span class="step flex items-center gap-1">
    <i class="fas fa-link"></i> <span class="hidden sm:inline">8. Links</span>
  </span>
</div>

    <!-- Step 1: Bio -->
    <div class="step-panel" id="step-1">
      <div class="mb-4">
        <label class="block mb-2 font-medium">Full Name  <span class="text-red-500">*</span></label>
        <input name="fullname" id="fullname" required type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      </div>
      <div class="mb-4">
        <label class="block mb-2 font-medium">Position Title  <span class="text-red-500">*</span></label>
        <input name="position" id="position" required type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="e.g., Full Stack Developer" />
      </div>
    </div>

    <!-- Step 2: Contact -->
    <div class="step-panel hidden" id="step-2">
      <div class="mb-4">
        <label class="block mb-2 font-medium">Email Address <span class="text-red-500">*</span></label>
        <input name="email" id="email" type="email" required class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      </div>
      <div class="mb-4">
        <label class="block mb-2 font-medium">Phone  <span class="text-red-500">*</span></label>
        <input name="phone" id="phone" type="text" required class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      </div>
      <div class="mb-4">
        <label class="block mb-2 font-medium">Location</label>
        <input name="location" id="location" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      </div>
    </div>

<div class="step-panel hidden" id="step-3">
  <div class="mb-4">
    <label class="block mb-2 font-medium">Professional Summary  <span class="text-red-500">*</span></label>
    <textarea name="summary" required class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" rows="4" placeholder="Brief summary about yourself..."></textarea>
  </div>
</div>
<div class="step-panel hidden" id="step-4">
  <div id="educationContainer">
    <div class="mb-4 education-entry">
      <label class="block mb-2 font-medium">School Name</label>
      <input name="school[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      <label class="block mt-2 mb-2 font-medium">Degree</label>
      <input name="degree[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      <label class="block mt-2 mb-2 font-medium">Year</label>
      <input name="edu_year[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
    </div>
  </div>
  <button type="button" onclick="addEducation()" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Add More Education</button>
</div>

<div class="step-panel hidden" id="step-5">
  <div id="workContainer">
    <div class="mb-4 work-entry">
      <label class="block mb-2 font-medium">Company</label>
      <input name="company[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      <label class="block mt-2 mb-2 font-medium">Role</label>
      <input name="role[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      <label class="block mt-2 mb-2 font-medium">Duration</label>
      <input name="duration[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
    </div>
  </div>
  <button type="button" onclick="addWork()" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Add More Experience</button>
</div>
<div class="step-panel hidden" id="step-6">
  <div id="projectsContainer">
    <div class="mb-4 project-entry">
      <label class="block mb-2 font-medium">Project Title</label>
      <input name="project_title[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      <label class="block mt-2 mb-2 font-medium">Description</label>
      <textarea name="project_description[]" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" rows="3"></textarea>
    </div>
  </div>
  <button type="button" onclick="addProject()" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Add More Projects</button>
</div>
<div class="step-panel hidden" id="step-7">
  <div id="skillsContainer">
    <div class="mb-4 skill-entry">
      <label class="block mb-2 font-medium">Skill</label>
      <input name="skills[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
    </div>
  </div>
  <button type="button" onclick="addSkill()" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Add More Skills</button>
</div>
<div class="step-panel hidden" id="step-8">
  <div id="linksContainer">
    <div class="mb-4 link-entry">
      <label class="block mb-2 font-medium">Platform (e.g. LinkedIn, GitHub)</label>
      <input name="platform[]" type="text" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
      <label class="block mt-2 mb-2 font-medium">URL</label>
      <input name="url[]" type="url" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
    </div>
  </div>
  <button type="button" onclick="addLink()" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Add More Links</button>
</div>
    <!-- Navigation <Butto>  </Butto>ns -->
    
    <div class="flex justify-between mt-6">
      <button type="button" id="prevBtn" class="bg-gray-400 text-white px-4 py-2 rounded hidden">Previous</button>
      <button type="button" id="nextBtn" class="bg-blue-600 text-white px-4 py-2 rounded">Next</button>
      <button type="submit" id="submitBtn" class="bg-purple-600 text-white px-4 py-2 rounded hidden">Generate Resume</button>
    </div>
  </form>
</div>
<div id="result"></div>
<script>
  const steps = document.querySelectorAll('.step');
  const panels = document.querySelectorAll('.step-panel');
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');
  const submitBtn = document.getElementById('submitBtn');
  let currentStep = 0;

  function showStep(index) {
    panels.forEach(p => p.classList.add('hidden'));
    panels[index].classList.remove('hidden');
    steps.forEach((s, i) => s.classList.toggle('text-blue-600', i === index));

    prevBtn.classList.toggle('hidden', index === 0);
    nextBtn.classList.toggle('hidden', index === panels.length - 1);
    submitBtn.classList.toggle('hidden', index !== panels.length - 1);
  }

  function validateStep(stepIndex) {
  let valid = true;
  const currentPanel = panels[stepIndex];
  const requiredFields = currentPanel.querySelectorAll('[required]');

  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      field.classList.add('border-red-500', 'shake');
      field.classList.remove('border-gray-300');
      valid = false;

      // Remove the shake class after 0.5s
      setTimeout(() => {
        field.classList.remove('shake');
      }, 500);
    } else {
      field.classList.remove('border-red-500');
      field.classList.add('border-gray-300');
    }
  });

  return valid;
}
  nextBtn.addEventListener('click', () => {
    if (validateStep(currentStep)) {
      currentStep++;
      showStep(currentStep);
    }
  });

  prevBtn.addEventListener('click', () => {
    currentStep--;
    showStep(currentStep);
  });

  showStep(currentStep);

  // ========== ADD SECTION FUNCTIONS ========== //
  function addEducation() {
    const container = document.getElementById("educationContainer");
    const clone = container.children[0].cloneNode(true);
    clone.querySelectorAll("input").forEach(input => input.value = "");
    container.appendChild(clone);
  }

  function addWork() {
    const container = document.getElementById("workContainer");
    const clone = container.children[0].cloneNode(true);
    clone.querySelectorAll("input").forEach(input => input.value = "");
    container.appendChild(clone);
  }

  function addProject() {
    const container = document.getElementById("projectsContainer");
    const clone = container.children[0].cloneNode(true);
    clone.querySelectorAll("input, textarea").forEach(el => el.value = "");
    container.appendChild(clone);
  }

  function addSkill() {
    const container = document.getElementById("skillsContainer");
    const clone = container.children[0].cloneNode(true);
    clone.querySelector("input").value = "";
    container.appendChild(clone);
  }

  function addLink() {
    const container = document.getElementById("linksContainer");
    const clone = container.children[0].cloneNode(true);
    clone.querySelectorAll("input").forEach(input => input.value = "");
    container.appendChild(clone);
  }
</script>
<div id="resultBoxWrapper" class="hidden mt-6 p-4 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-lg">
  <div id="resultBox" class="whitespace-pre-wrap p-4 bg-white dark:bg-gray-900 rounded-xl text-sm text-gray-900 dark:text-gray-100 max-h-96 overflow-y-auto font-mono border border-gray-300 dark:border-gray-700"></div>

  <div class="mt-4 flex flex-wrap gap-3 items-center">
    <button id="copy" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">📋 Copy</button>
    
    <button id="download" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">📥 Download</button>
    
    <select id="fileType" class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
      <option value="pdf">PDF</option>
      <option value="txt">TXT</option>
      <option value="md">Markdown</option>
    </select>

    <button id="linkBtn" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">🔗 Get Link</button>
  </div>

  <input type="text" id="generatedLink" readonly class="hidden mt-3 w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
</div>
<script>
document.getElementById('resumeForm').addEventListener('submit', async function (e) {
  e.preventDefault();

  const form = e.target;
  const resultBox = document.getElementById('resultBox');
  const wrapper = document.getElementById('resultBoxWrapper');
  const linkInput = document.getElementById('generatedLink');
  const formatSelect = document.getElementById('fileType');

  resultBox.textContent = '⏳ Generating resume...';
  wrapper.classList.remove('hidden');

  const data = new FormData(form);
  const res = await fetch('process.php', { method: 'POST', body: data });
  const json = await res.json();

  if (json.success) {
    const resume = json.resume;
    resultBox.textContent = resume;

    const timestamp = Date.now();
    const ext = formatSelect.value;
    const filename = `resume_${timestamp}.${ext}`;
    const fileUrl = `${location.origin}/resumes/${filename}`;
    setTimeout(() => {
      window.scrollTo({
        top: document.body.scrollHeight,
        behavior: "smooth"
      });
    }, 100);
    // 📦 Save to server
    await fetch('save_resume.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ content: resume, ext: ext, filename: filename })
    });

    // 📋 Copy
    document.getElementById('copy').onclick = () => {
      navigator.clipboard.writeText(resume)
        .then(() => alert('📋 Resume copied!'))
        .catch(() => alert('❌ Failed to copy.'));
    };

    // 📥 Download
    document.getElementById('download').onclick = () => {
      const mimeTypes = {
        pdf: 'application/pdf',
        txt: 'text/plain',
        md: 'text/markdown'
      };
      const blob = new Blob([resume], { type: mimeTypes[ext] });
      const a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = filename;
      a.click();
    };

    // 🔗 Link generation
    document.getElementById('linkBtn').onclick = () => {
      linkInput.classList.remove('hidden');
      linkInput.value = fileUrl;
    };

  } else {
    resultBox.textContent = `❌ Error: ${json.message || 'Unknown error.'}`;
  }
});
</script>
    <script src="../includes/js/theme.js"></script>
</body>
</html>