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

    document.querySelectorAll('[data-cleaning-selector]').forEach(function (form) {
      var result = document.querySelector('[data-cleaning-result]');

      form.addEventListener('submit', function (event) {
        event.preventDefault();

        var data = new FormData(form);
        var problem = data.get('problem');
        var floor = data.get('floor');
        var load = data.get('load');
        var approach = data.get('approach');
        var recommendation = {
          title: 'Routine pet-hair control system',
          sequence: 'Loosen embedded hair, use a pet-hair vacuum for the main pass, then automate frequent pickup where the floor plan allows it.',
          guide: '/pet-hair-cleaning/',
          guideLabel: 'Explore the pet-hair cleaning guide'
        };

        if (problem === 'stain') {
          recommendation = {
            title: floor === 'carpet' ? 'Source-first carpet stain system' : 'Surface-safe stain response',
            sequence: 'Blot first, identify the affected material, follow a compatible enzyme-cleaner label, and reassess only after the area has fully dried.',
            guide: '/pet-odor-stain-removal/',
            guideLabel: 'Open the odor and stain guide'
          };
        } else if (problem === 'odor') {
          recommendation = {
            title: 'Odor source and ventilation system',
            sequence: 'Find and clean the source before adding odor-control products. Improve drying and airflow, then reassess whether the odor returns.',
            guide: '/pet-odor-stain-removal/',
            guideLabel: 'Open the odor and stain guide'
          };
        } else if (approach === 'deep' && floor === 'carpet') {
          recommendation.title = 'Carpet-focused hair extraction system';
          recommendation.sequence = 'Agitate embedded hair, vacuum slowly in overlapping passes, clean the brush roll, and reserve automated pickup for maintenance.';
        } else if (floor === 'hard' && approach === 'automate') {
          recommendation.title = 'Automated hard-floor hair control';
          recommendation.sequence = 'Use scheduled pickup for loose hair, protect the brush from wrap, and add a manual edge pass for baseboards and corners.';
        }

        if (load === 'heavy') {
          recommendation.sequence += ' Heavy cleanup loads also benefit from shorter cleaning intervals and a brush-roll check after each cycle.';
        }

        if (result) {
          result.replaceChildren();

          var eyebrow = document.createElement('span');
          eyebrow.className = 'eyebrow';
          eyebrow.textContent = 'Your research-led starting point';

          var heading = document.createElement('h2');
          heading.textContent = recommendation.title;

          var summary = document.createElement('p');
          summary.textContent = recommendation.sequence;

          var evidence = document.createElement('p');
          var evidenceStrong = document.createElement('strong');
          evidenceStrong.textContent = 'Limit: ';
          evidence.append(evidenceStrong, 'This result recommends a category and sequence, not a guaranteed outcome or a specific unverified product.');

          var guide = document.createElement('a');
          guide.className = 'button';
          guide.href = recommendation.guide;
          guide.textContent = recommendation.guideLabel;

          result.append(eyebrow, heading, summary, evidence, guide);
        }

        window.petHomeScoutTrack && window.petHomeScoutTrack('decision_tool_complete', {
          problem: problem,
          floor: floor,
          cleanup_load: load,
          approach: approach,
          result_category: recommendation.title
        });
      });
    });
  });
}());
