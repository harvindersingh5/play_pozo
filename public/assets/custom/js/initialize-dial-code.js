$.fn.initializeDialCode = function (dial_code_obj) {
    return this.each(function () {
        const $element = $(this);

        let options = '<option value="">Select country code</option>';

        $.each(dial_code_obj, function (i, item) {
            options += `
                <option 
                    value="${item.dial_code}"
                    data-emoji="${item.emoji}"
                    data-name="${item.name.toLowerCase()}"
                    data-dial="${item.dial_code}">
                    ${item.emoji} ${item.dial_code} (${item.name})
                </option>
            `;
        });

        $element.html(options).select2({
            placeholder: 'Select country code',
            allowClear: true,
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatSelection,
            matcher: customMatcher
        });

        // Format for dropdown list (shows flag, code, and country name)
        function formatOption(option) {
            if (!option.id) return option.text;

            const emoji = option.element.dataset.emoji;
            const dial = option.element.dataset.dial;
            const name = option.element.dataset.name;

            return $(`
                <span style="display:flex; align-items:center; gap:8px;">
                    <span style="font-size:18px;">${emoji}</span>
                    <span style="font-weight:500;">${dial}</span>
                </span>
            `);
        }

        // Format for selected value (shows only flag and code)
        function formatSelection(option) {
            if (!option.id) return option.text;

            const emoji = option.element.dataset.emoji;
            const dial = option.element.dataset.dial;

            return $(`
                <span style="display:flex; align-items:center; gap:8px;">
                    <span style="font-size:18px;">${emoji}</span>
                    <span>${dial}</span>
                </span>
            `);
        }

        // Custom matcher to search by both country name and dial code
        function customMatcher(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }

            if (!data.element) {
                return null;
            }

            const term = params.term.toLowerCase();
            const country = data.element.dataset.name || '';
            const dial = data.element.dataset.dial || '';

            if (country.includes(term) || dial.includes(term)) {
                return data;
            }

            return null;
        }
    });
};