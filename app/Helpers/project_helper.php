<?php

/**
 * Generate dynamic HTML for form fields based on provided configuration and prefilled values.
 *
 * @param array $field_array Array of field configurations.
 * @param array $prefill_value Array of prefilled values for the fields.
 * @return string HTML string for the form fields.
 */
function createDynamicFieldHtml(array $field, $prefix = '', $sufix = '', array $prefill_value = []): string
{
    $html = '';
    $fieldName = $field['field_name'];
    $fieldTitle = $field['field_title'] ?? "";
    $fieldLabel = $field['field_label'];
    $fieldType = $field['field_type'];
    $fieldValidation = $field['field_validation'] ?? '';
    $fieldDefaultValue = $field['field_default_value'] ?? '';
    $fieldValue = $prefill_value[$fieldName] ?? $fieldDefaultValue;
    $fieldOptions = $field['field_options'] ?? null;

    // Generate label
    $html .= '<label for="' . htmlspecialchars($fieldName) . '" class="form-label">' . htmlspecialchars($fieldLabel) . '</label>';

    // Generate input based on field type
    if ($fieldType === 'select') {
        $html .= '<select title="' . htmlspecialchars($fieldTitle) . '" id="' . htmlspecialchars($fieldName) . '" name="' . $prefix . htmlspecialchars($fieldName) . $sufix . '" class="form-select" ' . $fieldValidation . '>';
        foreach ($fieldOptions as $value => $label) {
            $selected = ($fieldValue === $value) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars($value) . '"' . $selected . '>' . htmlspecialchars($label) . '</option>';
        }
        $html .= '</select>';
    } elseif ($fieldType === 'textarea') {
        $html .= '<textarea title="' . htmlspecialchars($fieldTitle) . '" id="' . htmlspecialchars($fieldName) . '" name="' . $prefix . htmlspecialchars($fieldName) . $sufix . '" class="form-control" ' . $fieldValidation . '>' . htmlspecialchars($fieldValue) . '</textarea>';
    } elseif ($fieldType === 'password') {
        $html .= '<input title="' . htmlspecialchars($fieldTitle) . '"  type="password" id="' . htmlspecialchars($fieldName) . '" name="' . $prefix . htmlspecialchars($fieldName) . $sufix . '" class="form-control" value="' . htmlspecialchars($fieldValue) . '" ' . $fieldValidation . '>';
    } else {
        $html .= '<input title="' . htmlspecialchars($fieldTitle) . '"  type="' . htmlspecialchars($fieldType) . '" id="' . htmlspecialchars($fieldName) . '" name="' . $prefix . htmlspecialchars($fieldName) . $sufix . '" class="form-control" value="' . htmlspecialchars($fieldValue) . '" ' . $fieldValidation . '>';
    }
    return $html;
}
