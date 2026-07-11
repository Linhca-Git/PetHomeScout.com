/* PetHomeScout.com - Robot Vacuum Selector Tool Logic */

document.addEventListener('DOMContentLoaded', () => {
  // Model Data (Falls back to static mock array if wordpressVacuums array isn't injected by backend)
  const vacuums = (typeof wordpressVacuums !== 'undefined' && wordpressVacuums !== null && wordpressVacuums.length > 0) ? wordpressVacuums : [
    {
      name: 'Roborock Q Revo MaxV',
      price: 1000,
      maxArea: 3500,
      petScore: 9.8,
      hasAI: true,
      floorRatings: { hardwood: 9.6, carpet: 9.2, mixed: 9.4 },
      merchant: 'roborock',
      tagline: 'Dual rubber rollers, extendable corner mops, and premium obstacle AI.'
    },
    {
      name: 'Roomba Combo j9+',
      price: 900,
      maxArea: 3000,
      petScore: 9.5,
      hasAI: true,
      floorRatings: { hardwood: 9.0, carpet: 9.6, mixed: 9.3 },
      merchant: 'roomba',
      tagline: 'Auto-retracting mop system, high carpet lift, and guaranteed poop avoidance.'
    },
    {
      name: 'Eufy X10 Pro Omni',
      price: 800,
      maxArea: 2500,
      petScore: 9.0,
      hasAI: true,
      floorRatings: { hardwood: 9.2, carpet: 8.6, mixed: 8.9 },
      merchant: 'eufy',
      tagline: 'Active roller blade detangler, dual spinning mops, premium features for less.'
    },
    {
      name: 'Shark Matrix Plus',
      price: 500,
      maxArea: 1800,
      petScore: 7.8,
      hasAI: false,
      floorRatings: { hardwood: 8.6, carpet: 7.9, mixed: 8.2 },
      merchant: 'shark',
      tagline: 'Grid-matrix cleaning pattern, bagless self-empty dock, moderate obstacle sensor.'
    },
    {
      name: 'Eufy Clean L60',
      price: 320,
      maxArea: 1200,
      petScore: 6.8,
      hasAI: false,
      floorRatings: { hardwood: 8.2, carpet: 7.2, mixed: 7.7 },
      merchant: 'eufy',
      tagline: 'Highly affordable, active hair slicing cylinder, standard LiDAR navigation.'
    }
  ];

  // Control Inputs
  const budgetSlider = document.getElementById('budgetSlider');
  const budgetValue = document.getElementById('budgetValue');
  const sizeSlider = document.getElementById('sizeSlider');
  const sizeValue = document.getElementById('sizeValue');
  
  const petRadios = document.getElementsByName('petCount');
  const toolFloor = document.getElementById('toolFloor');
  const wasteAvoidance = document.getElementById('wasteAvoidance');
  
  const resultsContainer = document.getElementById('resultsContainer');
  const matchResultsCount = document.getElementById('matchResultsCount');

  // Slider event listener bindings
  budgetSlider.addEventListener('input', () => {
    budgetValue.innerText = `$${budgetSlider.value}`;
    calculateMatches();
  });

  sizeSlider.addEventListener('input', () => {
    // Format with comma
    const val = parseInt(sizeSlider.value).toLocaleString();
    sizeValue.innerText = `${val} sq ft`;
    calculateMatches();
  });

  // Pet Radio styling triggers
  const petLabels = [
    document.getElementById('pet0'),
    document.getElementById('pet1'),
    document.getElementById('pet2')
  ];

  petLabels.forEach((lbl, idx) => {
    lbl.addEventListener('click', () => {
      petLabels.forEach(l => {
        l.style.border = '1px solid var(--border-color)';
        l.style.background = 'none';
        l.style.fontWeight = '500';
      });
      lbl.style.border = '2px solid var(--primary)';
      lbl.style.background = 'var(--primary-light)';
      lbl.style.fontWeight = '700';
      
      // Update check
      const radio = lbl.querySelector('input');
      radio.checked = true;
      calculateMatches();
    });
  });

  // Select boxes & Checkboxes listeners
  toolFloor.addEventListener('change', calculateMatches);
  wasteAvoidance.addEventListener('change', calculateMatches);

  // Match Engine
  function calculateMatches() {
    const budget = parseInt(budgetSlider.value);
    const size = parseInt(sizeSlider.value);
    const floor = toolFloor.value;
    const aiNeeded = wasteAvoidance.checked;
    
    // Read pet count value
    let petShedding = 1; // default moderate
    for (let i = 0; i < petRadios.length; i++) {
      if (petRadios[i].checked) {
        petShedding = parseInt(petRadios[i].value);
        break;
      }
    }

    // Map scoring
    let scoredItems = vacuums.map(vac => {
      let score = 100;
      let penalties = [];

      // 1. Budget Penalty
      if (vac.price > budget) {
        const diff = vac.price - budget;
        // Big penalty if over budget
        const pricePenalty = Math.min(45, Math.ceil(diff / 5));
        score -= pricePenalty;
        penalties.push(`Exceeds budget by $${diff}`);
      } else {
        // Bonus for being well within budget
        const savings = budget - vac.price;
        if (savings > 200) {
          score += 2; // small weight bonus
        }
      }

      // 2. Area Capability Penalty
      if (vac.maxArea < size) {
        const sizeDiff = size - vac.maxArea;
        const sizePenalty = Math.min(25, Math.ceil(sizeDiff / 100));
        score -= sizePenalty;
        penalties.push(`Sub-optimal battery for ${size.toLocaleString()} sq ft`);
      }

      // 3. Floor Scoring Adjustment
      const floorRating = vac.floorRatings[floor]; // out of 10
      const floorDiff = 10 - floorRating;
      score -= (floorDiff * 3); // max 7.5 deduction

      // 4. Pet Shedding Adaptation
      if (petShedding === 2) { // Heavy Shedding
        const petDiff = 10 - vac.petScore;
        score -= (petDiff * 5); // heavily penalize low pet scores
      } else if (petShedding === 0) {
        // Moderate pet score relevance
        score += 1;
      }

      // 5. AI Obstacle Avoidance requirement
      if (aiNeeded && !vac.hasAI) {
        score -= 30; // heavy penalty
        penalties.push('Lacks AI optical obstacle camera');
      }

      // Constrain score
      score = Math.max(10, Math.min(100, Math.round(score)));

      return {
        ...vac,
        matchPercent: score,
        penalties: penalties
      };
    });

    // Sort: highest compatibility first
    scoredItems.sort((a, b) => b.matchPercent - a.matchPercent);

    // Render results
    renderResults(scoredItems);
  }

  function renderResults(list) {
    resultsContainer.innerHTML = '';
    
    // Filter list to show active matches (matchPercent > 40%)
    const qualifiedMatches = list.filter(item => item.matchPercent >= 40);
    matchResultsCount.innerText = `${qualifiedMatches.length} Matches Found`;

    if (qualifiedMatches.length === 0) {
      resultsContainer.innerHTML = `
        <div style="text-align:center; padding: 40px 20px; color: var(--text-muted);">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px; color: var(--text-light);">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <h4>No matches exceed threshold</h4>
          <p style="font-size:13px; margin-top:8px;">Try raising your budget or selecting a smaller house size parameter.</p>
        </div>
      `;
      return;
    }

    qualifiedMatches.forEach((item, index) => {
      const card = document.createElement('div');
      card.className = 'result-item-card';

      // Highlight best option
      let badgeHtml = '';
      if (index === 0 && item.matchPercent >= 85) {
        badgeHtml = `<span class="result-tag best-match">BEST MATCH</span>`;
        card.style.borderColor = 'var(--success)';
        card.style.background = 'rgba(5, 150, 105, 0.02)';
      }

      // Check if price warnings
      let priceColor = 'var(--text-main)';
      let priceLabel = '';
      const budget = parseInt(budgetSlider.value);
      if (item.price > budget) {
        priceColor = 'var(--danger)';
        priceLabel = `<div style="font-size:10px; color:var(--danger); font-weight:600;">Over budget</div>`;
      }

      let penaltyHtml = '';
      if (item.penalties.length > 0) {
        penaltyHtml = `<div style="margin-top: 8px; font-size:11px; color:var(--text-muted); display:flex; flex-direction:column; gap:2px;">` +
          item.penalties.map(p => `<span style="display:inline-flex; align-items:center; gap:4px;"><span style="color:var(--danger); font-weight:bold;">!</span> ${p}</span>`).join('') +
          `</div>`;
      }

      card.innerHTML = `
        <div class="result-item-img">
          <svg width="48" height="48" viewBox="0 0 64 64" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="32" cy="32" r="26" fill="rgba(37,99,203,0.04)"/>
            <circle cx="32" cy="32" r="8" fill="rgba(37,99,203,0.08)"/>
            <!-- Paw Print in Center -->
            <circle cx="32" cy="32" r="1.5" fill="currentColor"></circle>
            <circle cx="30" cy="29.5" r="0.6" fill="currentColor"></circle>
            <circle cx="32" cy="28.5" r="0.6" fill="currentColor"></circle>
            <circle cx="34" cy="29.5" r="0.6" fill="currentColor"></circle>
          </svg>
        </div>
        <div class="result-item-info">
          <div class="result-item-tags">
            <span class="result-tag">${item.matchPercent}% Match</span>
            ${badgeHtml}
            <span class="result-tag">${item.maxArea} sq ft cap</span>
          </div>
          <h4 style="margin: 4px 0 6px;">${item.name}</h4>
          <p style="font-size: 13px; color: var(--text-muted); line-height:1.4;">${item.tagline}</p>
          ${penaltyHtml}
        </div>
        <div class="result-item-action">
          <div class="result-item-price" style="color: ${priceColor};">$${item.price}</div>
          ${priceLabel}
          <a href="/go/${item.merchant}/" class="btn btn-affiliate" style="padding: 8px 16px; font-size: 12px; margin-top: 8px; display:inline-block;">
            Shop Deal
          </a>
        </div>
      `;

      resultsContainer.appendChild(card);
    });
  }

  // Run initial match
  calculateMatches();
});
