<script>
    // Any <select data-sections="#target"> loads its sections into #target when it changes.
    document.querySelectorAll('select[data-sections]').forEach(function (classSelect) {
        var target = document.querySelector(classSelect.dataset.sections);
        if (!target) return;
        var urlTemplate = @json(route('section.by-class', '__ID__'));

        classSelect.addEventListener('change', function () {
            var placeholder = target.options[0] ? target.options[0].text : '— Select —';
            target.innerHTML = '';
            target.add(new Option(placeholder, ''));
            if (!this.value) return;

            fetch(urlTemplate.replace('__ID__', this.value), { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (list) { list.forEach(function (s) { target.add(new Option(s.name, s.id)); }); });
        });
    });
</script>