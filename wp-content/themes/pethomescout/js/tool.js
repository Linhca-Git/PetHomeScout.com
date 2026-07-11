(function () {
  var fixtures = [
    { name: 'HomeFlow R8 fixture', floor: 'mixed', hair: 'high', dock: 'yes', score: 9.1, evidence: 'Research-led fixture', note: 'Strong fit for mixed flooring, heavy shedding, and self-emptying preference.' },
    { name: 'CleanPath N7 fixture', floor: 'carpet', hair: 'high', dock: 'yes', score: 8.8, evidence: 'Research-led fixture', note: 'A practical comparison point for carpeted rooms and larger dust capacity.' },
    { name: 'FloorEase M4 fixture', floor: 'hardwood', hair: 'medium', dock: 'no', score: 8.4, evidence: 'Research-led fixture', note: 'Lower-complexity fixture for mostly hard floors and moderate hair.' }
  ];
  var form = document.querySelector('[data-vacuum-selector]'); if (!form) return;
  form.addEventListener('submit', function (event) { event.preventDefault(); var floor = form.querySelector('[name="floor"]:checked').value; var hair = form.querySelector('[name="hair"]:checked').value; var dock = form.querySelector('[name="dock"]:checked').value; var result = fixtures.slice().sort(function (a, b) { var as = (a.floor === floor ? 3 : 0) + (a.hair === hair ? 2 : 0) + (a.dock === dock ? 1 : 0); var bs = (b.floor === floor ? 3 : 0) + (b.hair === hair ? 2 : 0) + (b.dock === dock ? 1 : 0); return bs - as; })[0]; var panel = document.querySelector('[data-tool-result]'); panel.innerHTML = '<span class="tool-score">' + result.score + '</span><p class="tag">' + result.evidence + '</p><h2>' + result.name + '</h2><p>' + result.note + '</p><a class="button" href="/smart-tech/" data-track="affiliate_intent">Compare the factors</a>'; window.petHomeScoutTrack && window.petHomeScoutTrack('tool_completed', { content_cluster: 'smart-tech', tool: 'robot_vacuum_selector' }); });
}());
