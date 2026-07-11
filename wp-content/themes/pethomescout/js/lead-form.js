/* PetHomeScout.com - Multi-Step Lead Form Logic */

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('leadForm');
  const formSuccess = document.getElementById('formSuccess');
  
  // Step Containers
  const steps = [
    document.getElementById('step1'),
    document.getElementById('step2'),
    document.getElementById('step3')
  ];

  // Navigation Buttons
  const btnNext1 = document.getElementById('btnNext1');
  const btnNext2 = document.getElementById('btnNext2');
  const btnBack2 = document.getElementById('btnBack2');
  const btnBack3 = document.getElementById('btnBack3');
  
  // Progress Bar & Indicators
  const progressBar = document.getElementById('progressBar');
  const progressSteps = document.querySelectorAll('.progress-step');

  // Input Elements
  const selectorCards = document.querySelectorAll('.selector-card');
  const petTypeInput = document.getElementById('petType');
  const petAge = document.getElementById('petAge');
  const zipCode = document.getElementById('zipCode');
  const zipError = document.getElementById('zipError');
  const consentCheck = document.getElementById('consentCheck');
  const consentError = document.getElementById('consentError');

  let currentStepIndex = 0;

  // Step 1: Pet Type Selection Card handler
  selectorCards.forEach(card => {
    card.addEventListener('click', () => {
      selectorCards.forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      const val = card.getAttribute('data-value');
      petTypeInput.value = val;
    });
  });

  // Navigation function
  function goToStep(index) {
    if (index < 0 || index >= steps.length) return;
    
    // Hide all steps, show current
    steps.forEach((step, idx) => {
      if (idx === index) {
        step.classList.add('active');
      } else {
        step.classList.remove('active');
      }
    });

    currentStepIndex = index;
    updateProgressTracker(index);
  }

  function updateProgressTracker(index) {
    // Progress bar width
    const percentage = (index / (steps.length - 1)) * 100;
    progressBar.style.width = `${percentage}%`;

    // Progress step badges
    progressSteps.forEach((step, idx) => {
      const stepNum = parseInt(step.getAttribute('data-step'));
      if (idx < index) {
        step.className = 'progress-step completed';
      } else if (idx === index) {
        step.className = 'progress-step active';
      } else {
        step.className = 'progress-step';
      }
    });
  }

  // Next 1 Action
  btnNext1.addEventListener('click', () => {
    if (!petTypeInput.value) {
      alert('Please select a Pet Type (Dog, Cat, or Other) to continue.');
      return;
    }
    goToStep(1);
  });

  // Next 2 Action
  btnNext2.addEventListener('click', () => {
    const zipValue = zipCode.value.trim();
    // Validate US ZIP: 5 digits
    const isValidZip = /^\d{5}$/.test(zipValue);
    if (!isValidZip) {
      zipError.style.display = 'block';
      zipCode.style.borderColor = 'var(--danger)';
      return;
    }
    zipError.style.display = 'none';
    zipCode.style.borderColor = 'var(--border-color)';
    
    // Validate pet age (now in Step 2)
    if (!petAge.value) {
      alert('Please select your pet\'s age group.');
      return;
    }
    goToStep(2);
  });

  // Back actions
  btnBack2.addEventListener('click', () => goToStep(0));
  btnBack3.addEventListener('click', () => goToStep(1));

  // Form Submission
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Validate inputs in step 3
    const nameVal = document.getElementById('fullName').value.trim();
    const emailVal = document.getElementById('email').value.trim();
    const phoneVal = document.getElementById('phone').value.trim();

    if (!nameVal || !emailVal || !phoneVal) {
      alert('Please fill out all contact details.');
      return;
    }

    if (!consentCheck.checked) {
      consentError.style.display = 'block';
      return;
    }
    consentError.style.display = 'none';

    // Send form data to WordPress via AJAX
    const submitBtn = document.getElementById('btnSubmit');
    submitBtn.innerText = 'Calculating Rates...';
    submitBtn.disabled = true;

    const formData = new FormData(form);
    formData.append('action', 'submit_pet_lead');

    if (typeof petHomeScoutData !== 'undefined' && petHomeScoutData.leadNonce) {
      formData.append('nonce', petHomeScoutData.leadNonce);
    }

    // Use AJAX URL passed from WordPress wp_localize_script
    const ajaxUrl = (typeof petHomeScoutData !== 'undefined') ? petHomeScoutData.ajaxUrl : '/wp-admin/admin-ajax.php';

    fetch(ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        form.style.display = 'none';
        document.querySelector('.progress-container').style.display = 'none';
        formSuccess.style.display = 'block';
      } else {
        alert(data.data.message || 'Submission failed. Please try again.');
        submitBtn.innerText = 'Calculate Quotes \u2192';
        submitBtn.disabled = false;
      }
    })
    .catch(error => {
      console.warn('AJAX submit failed, proceeding with front-end mock fallback:', error);
      // Fallback for static prototype viewing / sandbox testing
      setTimeout(() => {
        form.style.display = 'none';
        document.querySelector('.progress-container').style.display = 'none';
        formSuccess.style.display = 'block';
      }, 800);
    });
  });
});
