(function () {
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-vacuum-selector]').forEach(function (form) {
      var result = document.querySelector('[data-tool-result]');
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        var data = new FormData(form);
        var floor = data.get('floor');
        var hair = data.get('hair');
        var dock = data.get('dock');
        var match = floor === 'carpet' && hair === 'high' ? 'Roborock Q Revo fixture' : floor === 'hardwood' ? 'Eufy Clean L60 fixture' : 'Roomba Combo j9+ fixture';
        if (dock === 'no' && floor !== 'carpet') match = 'Eufy Clean L60 fixture';
        if (result) {
          result.innerHTML = '<span class="eyebrow">Your fixture match</span><h2>' + match + '</h2><p>Matched for ' + floor + ' floors, ' + hair + ' shedding, and your dock preference.</p><p><strong>Research-led fixture.</strong> Merchant destinations remain disabled until approved.</p>';
        }
        window.petHomeScoutTrack && window.petHomeScoutTrack('tool_completed', { floor: floor, hair: hair, dock: dock });
      });
    });
  });
}());
