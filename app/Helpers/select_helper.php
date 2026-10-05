<?php
if (!function_exists('getSelectDateFilter')) {

    /**
     * Generates a select component for Date Filter.
     *
     * @param array $data {
     * The data for generating the select component.
     *
     * @type string $select_name The name attribute for the select element.
     * @type string $select_id The id attribute for the select element.
     * @type string $select_classes The class name of select element. (Default Class 'selectComponent')
     * @type string $select_attribute The all attribute of select element.
     * @type boolean $select_multiple for multiple select
     * @type string $option_selected The value to mark as selected.
     * @type string $option_label The label for the default option.
     * }
     * @return string The generated select component.
     */
    function getSelectDateFilter(array $data = [])
    {
        $year = date('Y');
        $options = [
            ['name' => 'Today', 'value' => date('Y-m-d') . ',' . date('Y-m-d')],
            ['name' => 'Yesterday', 'value' => date('Y-m-d', strtotime('-1 day')) . ',' . date('Y-m-d', strtotime('-1 day'))],
            ['name' => 'CurrentWeek', 'value' => date('Y-m-d', strtotime('last Monday')) . ',' . date('Y-m-d')],
            ['name' => 'LastWeek', 'value' => date('Y-m-d', strtotime('last Monday - 7 days')) . ',' . date('Y-m-d', strtotime('last Sunday'))],
            ['name' => 'CurrentMonth', 'value' => date('Y-m-01') . ',' . date('Y-m-d')],
            ['name' => 'LastMonth', 'value' => date('Y-m-01', strtotime('last month')) . ',' . date('Y-m-t', strtotime('last month'))],
            ['name' => 'Financial Year ' . $year - 1, 'value' => date(($year - 1) . '-04-01') . ',' . date(($year) . '-03-31')],
            ['name' => 'Financial Year ' . $year, 'value' => date($year . '-04-01') . ',' . date(($year + 1) . '-03-31')],
            ['name' => 'Financial Year ' . $year + 1, 'value' => date(($year + 1) . '-04-01') . ',' . date(($year + 2) . '-03-31')],

            // Add other options as needed
        ];
        $data['options'] = $options;
        $data['option_text_field_name'] = 'name';
        $data['option_value'] = 'value';
        return view('components/select', $data);
    }
}
if (!function_exists('getSelectCountryOptions')) {

    /**
     * Generates a select component for country.
     *
     * @param array $data {
     * The data for generating the select component.
     *
     * @type string $select_name The name attribute for the select element.
     * @type string $select_id The id attribute for the select element.
     * @type string $select_classes The class name of select element. (Default Class 'selectComponent')
     * @type string $select_attribute The all attribute of select element.
     * @type boolean $select_multiple for multiple select
     * @type string $option_selected The value to mark as selected.
     * @type string $option_label The label for the default option.
     * }
     * @return string The generated select component.
     */
    function getSelectCountryOptions(array $data = [])
    {
        $CountryModel = model('CountryModel'); // Adjust the model name as needed
        $CountryOptions = $CountryModel->getCountry(); // Replace with actual method call

        $data['options'] = $CountryOptions;
        $data['option_text_field_name'] = 'name';
        $data['option_value'] = 'id';
        return view('components/select', $data);
    }
}
if (!function_exists('getSelectStateOptions')) {

    /**
     * Generates a select component for State.
     *
     * @param array $data {
     * The data for generating the select component.
     *
     * @type string $select_name The name attribute for the select element.
     * @type string $select_id The id attribute for the select element.
     * @type string $select_classes The class name of select element. (Default Class 'selectComponent')
     * @type string $select_attribute The all attribute of select element.
     * @type boolean $select_multiple for multiple select
     * @type string $option_selected The value to mark as selected.
     * @type string $option_label The label for the default option.
     * }
     * @return string The generated select component.
     */
    function getSelectStateOptions(array $data = [])
    {
        $StateModel = model('StateModel'); // Adjust the model name as needed
        if (!empty($data['option_selected'])) {
            $StateOptions = $StateModel->getState($data['option_selected']); // Replace with actual method call
        } else {
            $StateOptions = $StateModel->getState(); // Replace with actual method call
        }


        $data['options'] = $StateOptions;
        $data['option_text_field_name'] = 'name';
        $data['option_value'] = 'id';
        return view('components/select', $data);
    }
}
if (!function_exists('getSelectCityOptions')) {

    /**
     * Generates a select component for City.
     *
     * @param array $data {
     * The data for generating the select component.
     *
     * @type string $select_name The name attribute for the select element.
     * @type string $select_id The id attribute for the select element.
     * @type string $select_classes The class name of select element. (Default Class 'selectComponent')
     * @type string $select_attribute The all attribute of select element.
     * @type boolean $select_multiple for multiple select
     * @type string $option_selected The value to mark as selected.
     * @type string $option_label The label for the default option.
     * }
     * @return string The generated select component.
     */
    function getSelectCityOptions(array $data = [])
    {
        $CityModel = model('CityModel'); // Adjust the model name as needed
        if (!empty($data['option_selected'])) {
            $CityOptions = $CityModel->getCity($data['option_selected']); // Replace with actual method call
        } else {
            $CityOptions = $CityModel->getCity(); // Replace with actual method call
        }

        $data['options'] = $CityOptions;
        $data['option_text_field_name'] = 'name';
        $data['option_value'] = 'id';
        return view('components/select', $data);
    }
}
