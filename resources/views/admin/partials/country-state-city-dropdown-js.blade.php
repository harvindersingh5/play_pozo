<script>
    $(document).ready(function() {
        var $countryDropdown = $('#country');
        var $stateDropdown = $('#state');
        var $cityDropdown = $('#city');

        function populateDropdown(selectElement, url, dataToSend, selectedValue) {
            $.ajax({
                url: url,
                type: 'GET',
                data: dataToSend,
                dataType: 'json',
                success: function(data) {
                    selectElement.empty().append('<option value="">Select ' + selectElement.attr('id').charAt(0).toUpperCase() + selectElement.attr('id').slice(1) + '</option>');
                    $.each(data, function(key, value) {
                        var option = $('<option>', { value: value.id, text: value.name });
                        if (selectedValue !== undefined && value.id == selectedValue) {
                            option.prop('selected', true);
                        }
                        selectElement.append(option);
                    });
                }
            });
        }

        // Initial load of countries
        var initialCountryId = $countryDropdown.data('selected');
        populateDropdown($countryDropdown, "{{ route('admin.get-countries') }}", {}, initialCountryId);

        // Load initial states if a country is pre-selected
        if (initialCountryId) {
            var initialStateId = $stateDropdown.data('selected');
            populateDropdown($stateDropdown, "{{ route('admin.get-states') }}", { country_id: initialCountryId }, initialStateId);
        } else {
            $stateDropdown.empty().append('<option value="">Select State</option>');
        }

        // Load initial cities if a state is pre-selected
        if (initialStateId) {
            var initialCityId = $cityDropdown.data('selected');
            populateDropdown($cityDropdown, "{{ route('admin.get-cities') }}", { state_id: initialStateId }, initialCityId);
        } else {
            $cityDropdown.empty().append('<option value="">Select City</option>');
        }

        // Event listener for country change
        $countryDropdown.change(function() {
            var countryId = $(this).val();
            $stateDropdown.empty().append('<option value="">Select State</option>');
            $cityDropdown.empty().append('<option value="">Select City</option>');
            if (countryId) {
                populateDropdown($stateDropdown, "{{ route('admin.get-states') }}", { country_id: countryId });
            }
        });

        // Event listener for state change
        $stateDropdown.change(function() {
            var stateId = $(this).val();
            $cityDropdown.empty().append('<option value="">Select City</option>');
            if (stateId) {
                populateDropdown($cityDropdown, "{{ route('admin.get-cities') }}", { state_id: stateId });
            }
        });
    });
</script>