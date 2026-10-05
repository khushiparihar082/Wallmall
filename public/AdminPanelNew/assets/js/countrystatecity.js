    // var selected_country_id = <#?= isset($country_id) ? json_encode($country_id) : 'null' ?>;
    // var selected_state_id = <#?= isset($state_id) ? json_encode($state_id) : 'null' ?>;
    // var selected_city_id = <#?= isset($city_id) ? json_encode($city_id) : 'null' ?>;
    // Initialize country selectize dropdown
    initializeSelectize('state_id', {
        placeholder: "Select State"
    });
    initializeSelectize('city_id', {
        placeholder: "Select City"
    });
    // Initialize country selectize dropdown
    initializeSelectize('country_id', {
        placeholder: "Select Country"
    }, CountryApiUrl, {}, 'country_id', 'country_name', selected_country_id).onchange(function(country_id) {
        // Handle onchange event for country selectize dropdown
        // Clear options of state selectize dropdown
        // Reset variables
        initializeSelectize('state_id').clearOptions().then(function() {
            // Initialize state selectize dropdown
            initializeSelectize('state_id', {
                placeholder: "Select State"
            }, StateApiUrl, {
                country_id: country_id
            }, 'state_id', 'state_name', selected_state_id).onchange(function(state_id) {
                // Handle onchange event for state selectize dropdown
                // Clear options of city selectize dropdown
                initializeSelectize('city_id').clearOptions().then(function() {
                    // Initialize city selectize dropdown
                    initializeSelectize('city_id', {
                        placeholder: "Select City"
                    }, CityApiUrl, {
                        state_id: state_id
                    }, 'city_id', 'city_name', selected_city_id);
                    selected_country_id = null;
                    selected_state_id = null;
                    selected_city_id = null;
                });
            });
        });
    });