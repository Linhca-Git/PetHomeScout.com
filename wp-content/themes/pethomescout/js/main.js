/* PetHomeScout.com - Core UI Scripts */

document.addEventListener('DOMContentLoaded', () => {
  // Sticky Header scroll effect
  const header = document.querySelector('header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });

  // Mobile Navigation Menu Toggle
  const navToggle = document.createElement('button');
  navToggle.className = 'mobile-nav-toggle';
  navToggle.setAttribute('aria-label', 'Toggle Navigation Menu');
  navToggle.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="4" y1="12" x2="20" y2="12"></line>
      <line x1="4" y1="6" x2="20" y2="6"></line>
      <line x1="4" y1="18" x2="20" y2="18"></line>
    </svg>
  `;

  const headerContainer = document.querySelector('.header-container');
  const nav = document.querySelector('nav');
  const headerActions = document.querySelector('.header-actions');

  if (headerContainer && nav && headerActions) {
    headerContainer.insertBefore(navToggle, headerActions);
    
    // Style toggle button
    navToggle.style.display = 'none';
    navToggle.style.background = 'none';
    navToggle.style.border = 'none';
    navToggle.style.cursor = 'pointer';
    navToggle.style.color = 'var(--text-main)';
    navToggle.style.padding = '8px';
    
    // Media query toggle control
    const handleMobileLayout = (e) => {
      if (e.matches) {
        navToggle.style.display = 'block';
        nav.style.display = 'none';
        
        // Add mobile styles to nav
        nav.style.position = 'absolute';
        nav.style.top = 'var(--header-height)';
        nav.style.left = '0';
        nav.style.width = '100%';
        nav.style.background = 'var(--bg-card)';
        nav.style.borderBottom = '1px solid var(--border-color)';
        nav.style.padding = '24px';
        nav.style.boxShadow = 'var(--shadow-lg)';
        
        const navUl = nav.querySelector('ul');
        if (navUl) {
          navUl.style.flexDirection = 'column';
          navUl.style.gap = '16px';
        }
      } else {
        navToggle.style.display = 'none';
        nav.style.display = 'block';
        nav.style.position = 'static';
        nav.style.padding = '0';
        nav.style.boxShadow = 'none';
        nav.style.border = 'none';
        
        const navUl = nav.querySelector('ul');
        if (navUl) {
          navUl.style.flexDirection = 'row';
          navUl.style.gap = '32px';
        }
      }
    };
    
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    handleMobileLayout(mediaQuery);
    mediaQuery.addEventListener('change', handleMobileLayout);

    navToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const isVisible = nav.style.display === 'block';
      nav.style.display = isVisible ? 'none' : 'block';
    });

    // Close menu on click outside
    document.addEventListener('click', () => {
      if (window.matchMedia('(max-width: 768px)').matches) {
        nav.style.display = 'none';
      }
    });
  }

  // Active navigation tracking
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('nav a');
  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href && currentPath.includes(href)) {
      link.classList.add('active');
    }
  });

  // Track and enhance Affiliate outbound link interactions
  const affiliateLinks = document.querySelectorAll('a[href*="/go/"]');
  affiliateLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      // For local prototype navigation, rewrite URLs to match the static file structure
      const target = link.getAttribute('href');
      if (target && !target.includes('index.html')) {
        if (target.endsWith('/')) {
          link.setAttribute('href', target + 'index.html');
        } else {
          link.setAttribute('href', target + '/index.html');
        }
      }
    });
  });
});

// Horizontal slider scroll navigation
function scrollSlider(amount) {
  const slider = document.getElementById('categories-slider');
  if (slider) {
    slider.scrollBy({ left: amount, behavior: 'smooth' });
  }
}

// Hub Pages Dynamic Filtering System
document.addEventListener('DOMContentLoaded', () => {
  const tagPills = document.querySelectorAll('.subtopic-tags .tag-pill');
  const filterCheckboxes = document.querySelectorAll('.filter-sidebar .filter-section input[type="checkbox"]');
  const productCards = document.querySelectorAll('.universal-product-card');

  if (productCards.length > 0) {
    // 1. Tag pills filter click handler
    tagPills.forEach(pill => {
      // Skip if pill has inline onclick redirect (e.g. Robot Vacuums redirect)
      if (pill.getAttribute('onclick')) return;

      pill.addEventListener('click', () => {
        tagPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');

        const filterValue = pill.textContent.trim().toLowerCase();
        
        productCards.forEach(card => {
          const tags = (card.getAttribute('data-tags') || '').toLowerCase();
          
          if (filterValue.startsWith('all') || tags.includes(filterValue)) {
            card.style.display = 'grid'; // Restore card layout
          } else {
            card.style.display = 'none';
          }
        });
      });
    });

    // 2. Checkboxes sidebar filter change handler
    filterCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', () => {
        // Find which category filters are checked
        const checkedCategories = [];
        const categoryCheckboxes = document.querySelectorAll('.filter-section:first-of-type input[type="checkbox"]');
        
        categoryCheckboxes.forEach(cb => {
          if (cb.checked) {
            const catLabel = cb.nextElementSibling.textContent.trim().toLowerCase();
            checkedCategories.push(catLabel);
          }
        });

        productCards.forEach(card => {
          const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
          
          if (checkedCategories.length === 0) {
            card.style.display = 'none';
          } else if (checkedCategories.includes(cardCategory)) {
            card.style.display = 'grid';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });

    // 3. Clear filters click handler
    const clearBtn = document.querySelector('.filter-sidebar span');
    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        filterCheckboxes.forEach(cb => {
          cb.checked = false;
        });
        // Check all checkboxes of the first category section to restore default
        const categoryCheckboxes = document.querySelectorAll('.filter-section:first-of-type input[type="checkbox"]');
        categoryCheckboxes.forEach(cb => cb.checked = true);

        productCards.forEach(card => {
          card.style.display = 'grid';
        });

        // Set All Active tag pill
        tagPills.forEach(p => p.classList.remove('active'));
        const firstPill = document.querySelector('.subtopic-tags .tag-pill:first-of-type');
        if (firstPill) firstPill.classList.add('active');
      });
    }
  }
});
