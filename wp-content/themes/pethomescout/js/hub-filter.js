(function () {
  var root = document.querySelector('[data-hub-filter]');
  if (!root) return;
  var cards = Array.prototype.slice.call(document.querySelectorAll('[data-guide-tags], [data-product-tags]'));
  var status = document.querySelector('[data-filter-status]');
  var categoryChecks = Array.prototype.slice.call(document.querySelectorAll('[data-filter-category]'));
  var merchantChecks = Array.prototype.slice.call(document.querySelectorAll('[data-filter-merchant]'));
  var clearButton = document.querySelector('[data-filter-clear]');
  var activeFilter = 'all';

  function values(checks) {
    return checks.filter(function (check) { return check.checked; }).map(function (check) { return check.value.toLowerCase(); });
  }

  function render() {
    var categories = values(categoryChecks);
    var merchants = values(merchantChecks);
    var visible = 0;
    cards.forEach(function (card) {
      var cardText = (card.textContent || '').toLowerCase();
      var tags = (card.dataset.productTags || card.dataset.guideTags || cardText).toLowerCase().split(/\s+/);
      var category = (card.dataset.productCategory || (cardText.indexOf('safety') !== -1 || cardText.indexOf('gate') !== -1 ? 'safety' : cardText.indexOf('floor') !== -1 ? 'flooring' : 'furniture')).toLowerCase();
      tags.push(category);
      var cardMerchants = (card.dataset.merchants || cardText).toLowerCase().split(/\s+/);
      var matchesPill = activeFilter === 'all' || tags.indexOf(activeFilter) !== -1;
      var matchesCategory = activeFilter !== 'all' || !categories.length || categories.indexOf(category) !== -1;
      var matchesMerchant = !merchants.length || merchants.some(function (merchant) { return cardMerchants.indexOf(merchant) !== -1; });
      var show = matchesPill && matchesCategory && matchesMerchant;
      card.hidden = !show;
      if (show) visible += 1;
    });
    if (status) status.textContent = visible + ' matching products';
  }

  root.querySelectorAll('[data-filter]').forEach(function (button) {
    button.addEventListener('click', function () {
      activeFilter = button.dataset.filter.toLowerCase();
      root.querySelectorAll('[data-filter]').forEach(function (item) { item.classList.toggle('is-active', item === button); });
      render();
      window.petHomeScoutTrack && window.petHomeScoutTrack('comparison_interaction', { interaction_type: 'hub_filter', filter: activeFilter });
    });
  });
  categoryChecks.concat(merchantChecks).forEach(function (check) { check.addEventListener('change', render); });
  if (clearButton) clearButton.addEventListener('click', function () {
    categoryChecks.concat(merchantChecks).forEach(function (check) { check.checked = false; });
    activeFilter = 'all';
    root.querySelectorAll('[data-filter]').forEach(function (item) { item.classList.toggle('is-active', item.dataset.filter.toLowerCase() === 'all'); });
    render();
  });
  render();
}());
