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
          result.replaceChildren();
          var eyebrow = document.createElement('span');
          eyebrow.className = 'eyebrow';
          eyebrow.textContent = 'Your fixture match';
          var heading = document.createElement('h2');
          heading.textContent = match;
          var summary = document.createElement('p');
          summary.textContent = 'Matched for ' + floor + ' floors, ' + hair + ' shedding, and your dock preference.';
          var evidence = document.createElement('p');
          var evidenceStrong = document.createElement('strong');
          evidenceStrong.textContent = 'Research-led fixture.';
          evidence.append(evidenceStrong, ' Merchant destinations remain disabled until approved.');
          result.append(eyebrow, heading, summary, evidence);
        }
        window.petHomeScoutTrack && window.petHomeScoutTrack('decision_tool_complete', { floor: floor, hair: hair, dock: dock });
      });
    });
  });
}());
