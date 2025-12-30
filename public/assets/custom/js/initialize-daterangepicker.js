/**
 * Initialize daterangepicker as a jQuery plugin
 * @param {object} options - Daterangepicker settings
 * @param {function} options.onApply - Callback when Apply button is clicked
 * @param {function} options.onChange - Optional callback during date selection
 * @param {string} options.dateFormat - Date format (default: 'YYYY-MM-DD')
 * @param {object} options.pickerOptions - Additional daterangepicker options
 */
$.fn.initDateRangePicker = function (options = {}) {
    const defaults = {
        onApply: null,
        onChange: null,
        dateFormat: DATE_FORMAT,
        pickerOptions: {}
    };

    const settings = $.extend({}, defaults, options);

    return this.each(function () {
        const $element = $(this);
        const element = this;

        // Initialize daterangepicker
        $element.daterangepicker({
            autoUpdateInput: false, // We'll handle input ourselves
            locale: {
                format: settings.dateFormat,
                separator: ' - '
            },
            ...settings.pickerOptions
        }, function (start, end, label) {
            // Set input element value
            element.value = start.format(settings.dateFormat) + ' - ' + end.format(settings.dateFormat);

            // Optional callback during date selection
            if (settings.onChange) {
                settings.onChange(start, end, label, element);
            }
        });

        // Handle Apply button
        $element.on('apply.daterangepicker', function (ev, picker) {
            // Call the provided callback
            if (settings.onApply) {
                settings.onApply(picker.startDate, picker.endDate, element);
            }
        });

        // Optional: clear input on cancel
        $element.on('cancel.daterangepicker', function (ev, picker) {
            element.value = '';
        });
    });
};
