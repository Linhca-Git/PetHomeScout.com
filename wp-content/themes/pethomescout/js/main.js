/* PetHomeScout.com - Core UI Scripts */

window.petHomeScoutTrack = window.petHomeScoutTrack || function (eventName, details) {
  const path = window.location.pathname || '/';
  const pageType = path === '/' ? 'home' : path.split('/').filter(Boolean)[0] || 'page';
  const payload = Object.assign({
    event: eventName,
    page_path: path,
    page_type: pageType,
    content_type: document.body ? document.body.getAttribute('data-content-type') || pageType : pageType,
  }, details || {});
  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push(payload);
  window.dispatchEvent(new CustomEvent('pethomescout:event', { detail: payload }));
};

document.addEventListener('DOMContentLoaded', () => {
  const mainLandmark = document.querySelector('main');
  if (mainLandmark && !mainLandmark.id) {
    mainLandmark.id = 'main-content';
  }

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
  navToggle.setAttribute('aria-expanded', 'false');
  navToggle.setAttribute('type', 'button');
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
    nav.id = nav.id || 'primary-navigation';
    nav.setAttribute('aria-label', nav.getAttribute('aria-label') || 'Primary navigation');
    navToggle.setAttribute('aria-controls', nav.id);
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
        headerContainer.classList.remove('mobile-menu-open');
        
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
      navToggle.setAttribute('aria-expanded', isVisible ? 'false' : 'true');
      headerContainer.classList.toggle('mobile-menu-open', !isVisible);
    });

    // Close menu on click outside
    document.addEventListener('click', () => {
      if (window.matchMedia('(max-width: 768px)').matches) {
        nav.style.display = 'none';
        navToggle.setAttribute('aria-expanded', 'false');
        headerContainer.classList.remove('mobile-menu-open');
      }
    });

    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && navToggle.getAttribute('aria-expanded') === 'true') {
        nav.style.display = 'none';
        navToggle.setAttribute('aria-expanded', 'false');
        headerContainer.classList.remove('mobile-menu-open');
        navToggle.focus();
      }
    });
  }

  // Active navigation tracking
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('nav a');
  navLinks.forEach(link => {
    const href = new URL(link.getAttribute('href'), window.location.origin).pathname;
    const isHome = href === '/';
    if ((isHome && currentPath === '/') || (!isHome && currentPath.startsWith(href))) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  // Track affiliate intent without rewriting WordPress /go/ URLs.
  const affiliateLinks = document.querySelectorAll('a[href*="/go/"]');
  affiliateLinks.forEach(link => {
    link.addEventListener('click', () => {
      window.petHomeScoutTrack && window.petHomeScoutTrack('affiliate_intent', {
        merchant_id: link.getAttribute('data-merchant') || '',
        product_id: link.getAttribute('data-product') || '',
        cta_position: link.getAttribute('data-cta-position') || '',
      });
    });
  });

  document.querySelectorAll('[data-track]').forEach(element => {
    if (element.matches('a[href*="/go/"]')) {
      return;
    }

    element.addEventListener('click', () => {
      const eventName = element.getAttribute('data-track');
      if (!eventName) {
        return;
      }

      window.petHomeScoutTrack && window.petHomeScoutTrack(eventName, {
        merchant_id: element.getAttribute('data-merchant') || '',
        product_id: element.getAttribute('data-product') || '',
        service_type: element.getAttribute('data-service') || '',
        cta_position: element.getAttribute('data-cta-position') || '',
        evidence_status: element.getAttribute('data-evidence-status') || '',
      });
    });
  });

  // Accessibility enhancements for MVP templates and fixture icons.
  document.querySelectorAll('.comparison-table-wrapper').forEach((wrapper, index) => {
    wrapper.setAttribute('role', 'region');
    wrapper.setAttribute('tabindex', '0');
    wrapper.setAttribute('aria-label', wrapper.getAttribute('aria-label') || `Scrollable comparison table ${index + 1}`);
  });

  document.querySelectorAll('button[disabled]').forEach(button => {
    if (!button.getAttribute('type')) {
      button.setAttribute('type', 'button');
    }
    button.setAttribute('aria-disabled', 'true');
  });

  document.querySelectorAll('.dashicons, .family-product-art, .feed-item-img, .vs-product-thumb, .tool-banner-icon').forEach(icon => {
    icon.setAttribute('aria-hidden', 'true');
  });

  // Make prototype card-level data-href navigation click and keyboard accessible.
  document.querySelectorAll('[data-href]').forEach(card => {
    if (card.matches('a, button, input, select, textarea')) {
      return;
    }

    const destination = card.getAttribute('data-href');
    if (!destination) {
      return;
    }

    card.setAttribute('role', 'link');
    card.setAttribute('tabindex', card.getAttribute('tabindex') || '0');
    if (!card.getAttribute('aria-label')) {
      const labelSource = card.querySelector('h2, h3, h4, .feed-item-title, .pick-title, a, strong, span:not(.dashicons)');
      const label = labelSource ? labelSource.textContent.trim() : '';
      if (label) {
        card.setAttribute('aria-label', label);
      }
    }
    card.addEventListener('click', event => {
      if (event.target.closest('a, button, input, select, textarea')) {
        return;
      }
      window.location.href = destination;
    });
    card.addEventListener('keydown', event => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        window.location.href = destination;
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
      // Skip pills that navigate instead of filtering.
      if (pill.getAttribute('data-href') || pill.getAttribute('onclick')) return;

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
