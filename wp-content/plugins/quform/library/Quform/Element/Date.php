<?php

/**
 * @copyright Copyright (c) 2009-2020 ThemeCatcher (https://www.themecatcher.net)
 */
class Quform_Element_Date extends Quform_Element_Field implements Quform_Element_Editable
{
    /**
     * Get the value formatted in HTML
     *
     * @return  string
     */
    public function getValueHtml()
    {
        $value = Quform::escape($this->getValueText());

        $value = apply_filters('quform_get_value_html_' . $this->getIdentifier(), $value, $this, $this->getForm());

        return $value;
    }

    /**
     * Get the value formatted in plain text
     *
     * @param   string  $separator
     * @return  string
     */
    public function getValueText($separator = ', ')
    {
        $value = '';

        if ( ! $this->isEmpty()) {
            try {
                $value = Quform::date(
                    $this->config('dateFormat'),
                    new DateTime($this->getValue(), new DateTimeZone('UTC')),
                    new DateTimeZone('UTC')
                );
            } catch (Exception $e) {
                // If there was an error creating the DateTime object, the value will be an empty string
            }
        }

        $value = apply_filters('quform_get_value_text_' . $this->getIdentifier(), $value, $this, $this->getForm());

        return $value;
    }

    /**
     * Is the given value valid for this element type
     *
     * @param   string  $value
     * @return  bool
     */
    protected function isValidValue($value)
    {
        if ( ! is_string($value)) {
            return false;
        }

        return preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $value);
    }

    /**
     * Prepare the dynamic default value
     *
     * Supports a date string in the format YYYY-MM-DD
     *
     * @param   string  $value
     * @return  string
     */
    public function prepareDynamicValue($value)
    {
        if (Quform::isNonEmptyString($value)) {
            $parts = explode('-', $value);

            if (isset($parts[0], $parts[1], $parts[2])) {
                $year = (int) $parts[0];
                $month = (int) $parts[1];
                $day = (int) $parts[2];

                if (checkdate($month, $day, $year)) {
                    try {
                        return Quform::date(
                            'Y-m-d',
                            new DateTime("$year-$month-$day", new DateTimeZone('UTC')),
                            new DateTimeZone('UTC')
                        );
                    } catch (Exception $e) {
                        // If there was an error creating the DateTime object, fall through to return the empty value
                    }
                }
            }
        }

        return $this->getEmptyValue();
    }

    /**
     * Get the HTML attributes for the field
     *
     * @param   array  $context
     * @return  array
     */
    protected function getFieldAttributes(array $context = array())
    {
        $attributes = array(
            'type' => 'text',
            'id' => $this->getUniqueId(),
            'name' => $this->getFullyQualifiedName(),
            'class' => Quform::sanitizeClass($this->getFieldClasses($context)),
            'placeholder' => 'YYYY-MM-DD',
            'data-options' => wp_json_encode($this->getDatepickerOptions())
        );

        if ( ! $this->isEmpty()) {
            $attributes['value'] = $this->getValue();
        }

        if ($this->config('readOnly')) {
            $attributes['readonly'] = true;
        }

        $attributes = apply_filters('quform_field_attributes', $attributes, $this, $this->form, $context);
        $attributes = apply_filters('quform_field_attributes_' . $this->getIdentifier(), $attributes, $this, $this->form, $context);

        return $attributes;
    }

    /**
     * Get the datepicker options for the field
     *
     * @return array
     */
    protected function getDatepickerOptions()
    {
        $options = array(
            'format' => $this->config('dateFormatJs'),
            'min' => $this->config('dateMin'),
            'max' => $this->config('dateMax'),
            'start' => $this->config('dateViewStart'),
            'depth' => $this->config('dateViewDepth'),
            'showFooter' => $this->config('dateShowFooter'),
            'locale' => $this->config('dateLocale'),
            'placeholder' => $this->config('placeholder'),
            'autoOpen' => $this->config('dateAutoOpen'),
            'identifier' => $this->getIdentifier()
        );

        return $options;
    }

    /**
     * Get the classes for the field
     *
     * @param   array  $context
     * @return  array
     */
    protected function getFieldClasses(array $context = array())
    {
        $classes = array(
            'quform-field',
            'quform-field-date',
            sprintf('quform-field-%s', $this->getIdentifier())
        );

        if ($this->form->config('tooltipsEnabled') && Quform::isNonEmptyString($this->config('tooltip')) && Quform::get($context, 'tooltipType') == 'field') {
            $classes[] = sprintf('quform-tooltip-%s', Quform::get($context, 'tooltipEvent'));
        }

        if (Quform::isNonEmptyString($this->config('customClass'))) {
            $classes[] = $this->config('customClass');
        }

        $classes = apply_filters('quform_field_classes', $classes, $this, $this->form, $context);
        $classes = apply_filters('quform_field_classes_' . $this->getIdentifier(), $classes, $this, $this->form, $context);

        return $classes;
    }

    /**
     * Get the HTML for the field
     *
     * @param   array   $context
     * @return  string
     */
    protected function getFieldHtml(array $context = array())
    {
        return Quform::getHtmlTag('input', $this->getFieldAttributes($context));
    }

    /**
     * Get the field HTML when editing
     *
     * @return string
     */
    public function getEditFieldHtml()
    {
        return $this->getFieldHtml();
    }

    /**
     * Render the CSS for this element
     *
     * @param   array   $context
     * @return  string
     */
    protected function renderCss(array $context = array())
    {
        $css = parent::renderCss($context);

        if ($context['fieldWidth'] == 'custom' && Quform::isNonEmptyString($context['fieldWidthCustom'])) {
            $css .= sprintf('.quform-input-date.quform-input-%s { width: %s; }', $this->getIdentifier(), Quform::addCssUnit($context['fieldWidthCustom']));
            $css .= sprintf('.quform-inner-%s > .quform-error > .quform-error-inner { float: left; min-width: %s; }', $this->getIdentifier(), Quform::addCssUnit($context['fieldWidthCustom']));
        }

        return $css;
    }

    /**
     * Get the list of CSS selectors
     *
     * @return array
     */
    protected function getCssSelectors()
    {
        return parent::getCssSelectors() + array(
            'datepickerHeader' => '%1$s-datepicker.quform-%2$s-datepicker.quform-datepicker .k-calendar .k-header, %1$s-datepicker.quform-%2$s-datepicker .k-calendar .k-header .k-state-hover',
            'datepickerHeaderText' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar .k-header .k-link',
            'datepickerHeaderTextHover' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar .k-header .k-link:hover',
            'datepickerFooter' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar .k-footer',
            'datepickerFooterText' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar .k-footer .k-link',
            'datepickerFooterTextHover' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar .k-footer .k-link:hover',
            'datepickerSelectionText' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar td.k-state-focused .k-link',
            'datepickerSelectionTextHover' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar td.k-state-focused .k-link:hover',
            'datepickerSelectionActiveText' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar td.k-state-selected.k-state-focused .k-link',
            'datepickerSelectionActiveTextHover' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar td.k-state-selected.k-state-focused .k-link:hover',
            'datepickerSelection' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar td.k-state-focused',
            'datepickerSelectionActive' => '%s-datepicker.quform-%s-datepicker.quform-datepicker .k-calendar td.k-state-selected.k-state-focused'
        );
    }

    /**
     * Does the given logic rule match the given value?
     *
     * @param   mixed  $value
     * @param   array  $rule
     * @return  bool
     */
    protected function isLogicValueMatch($value, array $rule)
    {
        if ($rule['operator'] == 'gt' || $rule['operator'] == 'lt') {
            if ( ! $this->isEmpty()) {
                $result = Quform::compareDates($value, $rule['value']);

                if ($result !== false) {
                    return $rule['operator'] == 'gt' ? $result === 1 : $result === -1;
                }
            }

            return false;
        }

        return parent::isLogicValueMatch($value, $rule);
    }

    /**
     * Get the default element configuration
     *
     * @param   string|null  $key  Get the config by key, if omitted the full config is returned
     * @return  array
     */
    public static function getDefaultConfig($key = null)
    {
        $config = apply_filters('quform_default_config_date', array(
            // Basic
            'label' => __('Date', 'quform'),
            'description' => '',
            'descriptionAbove' => '',
            'required' => false,

            // Styles
            'labelIcon' => '',
            'fieldIconLeft' => '',
            'fieldIconRight' => 'qicon-calendar',
            'fieldSize' => 'inherit',
            'fieldWidth' => 'inherit',
            'fieldWidthCustom' => '',
            'customClass' => '',
            'customElementClass' => '',
            'styles' => array(),

            // Labels
            'placeholder' => '',
            'subLabel' => '',
            'subLabelAbove' => '',
            'adminLabel' => '',
            'tooltip' => '',
            'tooltipType' => 'inherit',
            'tooltipEvent' => 'inherit',
            'labelPosition' => 'inherit',
            'labelWidth' => '',

            // Logic
            'logicEnabled' => false,
            'logicAction' => true,
            'logicMatch' => 'all',
            'logicRules' => array(),

            // Data
            'defaultValue' => '',
            'dynamicDefaultValue' => false,
            'dynamicKey' => '',
            'dateMin' => '',
            'dateMax' => '',
            'dateViewStart' => 'month',
            'dateViewDepth' => 'month',
            'dateShowFooter' => false,
            'dateLocale' => '',
            'dateFormatJs' => '',
            'dateFormat' => '',
            'dateAutoOpen' => true,
            'readOnly' => false,
            'showInEmail' => true,
            'saveToDatabase' => true,

            // Advanced
            'visibility' => '',
            'validators' => array(),

            // Translation
            'messageRequired' => '',
            'messageDateInvalidDate' => '',
            'messageDateTooEarly' => '',
            'messageDateTooLate' => ''
        ));

        $config['type'] = 'date';

        if (Quform::isNonEmptyString($key)) {
            return Quform::get($config, $key);
        }

        return $config;
    }
}
