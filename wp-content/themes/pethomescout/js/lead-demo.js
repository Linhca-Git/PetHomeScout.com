(function () {
  function track(name, details) {
    window.petHomeScoutTrack && window.petHomeScoutTrack(name, details || {});
  }
  document.querySelectorAll('[data-lead-demo]').forEach(function (form) {
    var step = 1;
    var choice = '';
    var service = form.getAttribute('data-service');
    form.querySelectorAll('.form-error').forEach(function (error) {
      error.setAttribute('role', 'alert');
      error.setAttribute('aria-live', 'polite');
    });
    form.querySelectorAll('[data-choice]').forEach(function (button) {
      button.setAttribute('aria-pressed', 'false');
    });
    var show = function (next) {
      step = next;
      form.querySelectorAll('.lead-step').forEach(function (panel) {
        var isActive = Number(panel.dataset.step) === step;
        panel.classList.toggle('is-active', isActive);
        panel.hidden = !isActive;
        panel.setAttribute('aria-hidden', isActive ? 'false' : 'true');
        panel.setAttribute('aria-current', isActive ? 'step' : 'false');
      });
      var heading = form.querySelector('.lead-step.is-active h2');
      if (heading) {
        heading.focus();
      }
    };
    show(step);
    form.querySelectorAll('[data-choice]').forEach(function (button) { button.addEventListener('click', function () { choice = button.dataset.choice; form.querySelectorAll('[data-choice]').forEach(function (item) { var selected = item === button; item.classList.toggle('is-selected', selected); item.setAttribute('aria-pressed', selected ? 'true' : 'false'); }); }); });
    form.querySelectorAll('.step-next').forEach(function (button) { button.addEventListener('click', function () {
      var panel = button.closest('.lead-step'); var error = panel.querySelector('.form-error'); error.textContent = '';
      if (step === 1 && !choice) { error.textContent = 'Choose the pet that needs support.'; return; }
      if (step === 2) { var zip = form.querySelector('[name="zip"]').value.trim(); var breed = form.querySelector('[name="breed"]').value.trim(); if (!/^\d{5}$/.test(zip) || !breed) { error.textContent = 'Enter a 5-digit ZIP code and breed or mix.'; return; } }
      if (step === 1) {
        track('lead_form_start', { service_type: service, step: step });
      }
      show(step + 1);
    }); });
    form.querySelectorAll('.step-back').forEach(function (button) { button.addEventListener('click', function () { show(step - 1); }); });
    form.addEventListener('submit', function (event) { event.preventDefault(); var panel = form.querySelector('.lead-step.is-active'); var error = panel.querySelector('.form-error'); var name = form.querySelector('[name="name"]').value.trim(); var email = form.querySelector('[name="email"]').value.trim(); var phone = form.querySelector('[name="phone"]').value.trim(); var consent = form.querySelector('[name="consent"]').checked; if (!name || !/^\S+@\S+\.\S+$/.test(email) || !phone || !consent) { error.textContent = 'Complete all fields and confirm consent to continue.'; return; } track('lead_form_demo_submit', { service_type: service }); form.querySelectorAll('.lead-step').forEach(function (panel) { panel.hidden = true; panel.classList.remove('is-active'); panel.setAttribute('aria-hidden', 'true'); panel.setAttribute('aria-current', 'false'); }); var success = form.querySelector('.lead-success'); success.hidden = false; success.focus(); });
    form.addEventListener('focusin', function () { track('lead_form_view', { service_type: service }); }, { once: true });
  });
}());
