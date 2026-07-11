(function () {
  var root = document.querySelector('[data-hub-filter]');
  if (!root) return;
  var cards = document.querySelectorAll('[data-guide-tags]');
  var status = document.querySelector('[data-filter-status]');
  root.querySelectorAll('[data-filter]').forEach(function (button) { button.addEventListener('click', function () { var filter = button.dataset.filter; root.querySelectorAll('[data-filter]').forEach(function (item) { item.classList.toggle('is-active', item === button); }); var visible = 0; cards.forEach(function (card) { var show = filter === 'all' || card.dataset.guideTags.split(' ').indexOf(filter) !== -1; card.hidden = !show; if (show) visible += 1; }); if (status) status.textContent = filter === 'all' ? 'Showing all guides' : 'Showing ' + visible + ' guides for ' + filter; window.petHomeScoutTrack && window.petHomeScoutTrack('hub_filter_used', { content_cluster: 'smart-tech', filter: filter }); }); });
}());
