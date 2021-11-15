<?php

/**
 * @copyright Copyright (c) 2009-2020 ThemeCatcher (https://www.themecatcher.net)
 */
class Quform_Element_Recaptcha extends Quform_Element_Field
{
    /**
     * The reCAPTCHA element has a static name
     *
     * @return string
     */
    public function getName()
    {
        return 'g-recaptcha-response';
    }

    /**
     * Get the classes for the outermost element wrapper
     *
     * @param   array  $context
     * @return  array
     */
    protected function getElementClasses(array $context = array())
    {
        $classes = parent::getElementClasses($context);

        if (($this->config('recaptchaVersion') == 'v3' || $this->config('recaptchaSize') == 'invisible') && $this->config('recaptchaBadge') != 'inline') {
            $classes[] = 'quform-recaptcha-no-size';
        }

        return $classes;
    }

    /**
     * Get the HTML for the element label
     *
     * @param   array        $context
     * @param   string|bool  $forAttribute  Set the "for" attribute to the element unique ID
     * @param   bool         $id            Add a unique ID to the label
     * @return  string
     */
    protected function getLabelHtml(array $context = array(), $forAttribute = true, $id = false)
    {
        if ($this->config('recaptchaVersion') == 'v3' || $this->config('recaptchaSize') == 'invisible') {
            return '';
        }

        return parent::getLabelHtml($context, false);
    }

    /**
     * Get the HTML for the element input wrapper
     *
     * @param   array   $context
     * @return  string
     */
    protected function getInputHtml(array $context = array())
    {
        $output = sprintf('<div class="%s">', Quform::escape(Quform::sanitizeClass($this->getInputClasses($context))));
        $output .= $this->getFieldHtml();
        $output .= '</div>';

        return $output;
    }

    /**
     * Get the HTML for the field
     *
     * @param   array   $context
     * @return  string
     */
    protected function getFieldHtml(array $context = array())
    {
        $output = '';

        if ( ! Quform::isNonEmptyString($this->config('recaptchaSiteKey'))) {
            $output .= esc_html__('To use reCAPTCHA you must enter the API keys on the Quform settings page.', 'quform');
        } else {
            $config = array(
                'sitekey' => $this->config('recaptchaSiteKey'),
                '_version' => $this->config('recaptchaVersion'), /* 'version' is reserved */
                'size' => $this->config('recaptchaSize'),
                'type' => $this->config('recaptchaType'),
                'theme' => $this->config('recaptchaTheme'),
                'badge' => $this->config('recaptchaBadge'),
            );

            $output .= sprintf(
                '<div class="quform-recaptcha" data-config="%s"></div>',
                Quform::escape(wp_json_encode($config))
            );

            if ($this->config('recaptchaVersion') == 'v3' || $this->config('recaptchaSize') == 'invisible') {
                $output .= sprintf('<noscript>%s</noscript>', esc_html__('Please enable JavaScript to submit this form.', 'quform'));
            } else {
                $output .= '<noscript><div>';
                $output .= '<div style="width: 302px; height: 422px; position: relative;">';
                $output .= '<div style="width: 302px; height: 422px; position: absolute;">';
                $output .= sprintf('<iframe src="%s" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none;"></iframe>', esc_url(sprintf('https://www.google.com/recaptcha/api/fallback?k=%s', $this->config('recaptchaSiteKey'))));
                $output .= '</div></div>';
                $output .= '<div style="width: 300px; height: 60px; border-style: none; bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px; background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">';
                $output .= '<textarea name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;"></textarea>';
                $output .= '</div></div></noscript>';
            }

            if ( ! wp_script_is('quform-recaptcha', 'enqueued')) {
                wp_enqueue_script('quform-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=QuformRecaptchaLoaded&render=explicit&hl=' . $this->config('recaptchaLang'), array('jquery'), false, true);
                wp_add_inline_script('quform-recaptcha', 'window.QuformRecaptchaLoaded=function(){window.grecaptcha&&window.jQuery&&jQuery(".quform-recaptcha").each(function(){var a=jQuery(this),c=a.data("config");a.is(":empty")&&("v2"===c._version&&"invisible"===c.size&&(c.callback=function(){a.closest(".quform-form").data("quform").submit()}),a.data("recaptcha-id",grecaptcha.render(a[0],c)))})};', 'before');
            }
        }

        return $output;
    }

    /**
     * Inherit settings from this element into the context
     *
     * @param   array  $context
     * @return  array
     */
    protected function prepareContext(array $context = array())
    {
        $context = parent::prepareContext($context);

        // Inside labels are not possible so set it above
        if ( ! in_array($context['labelPosition'], array('', 'left'), true)) {
            $context['labelPosition'] = '';
        }

        // Icon is the only possible tooltip type for this element
        $context['tooltipType'] = 'icon';

        return $context;
    }

    /**
     * Get the default element configuration
     *
     * @param   string|null  $key  Get the config by key, if omitted the full config is returned
     * @return  array
     */
    public static function getDefaultConfig($key = null)
    {
        $config = apply_filters('quform_default_config_recaptcha', array(
            // Basic
            'label' => __('Are you human?', 'quform'),
            'description' => '',
            'descriptionAbove' => '',
            'recaptchaVersion' => 'v2',
            'recaptchaSize' => 'normal',
            'recaptchaType' => 'image',
            'recaptchaTheme' => 'light',
            'recaptchaBadge' => 'bottomright',
            'recaptchaLang' => '',
            'recaptchaThreshold' => '0.5',

            // Styles
            'labelIcon' => '',
            'customElementClass' => '',
            'styles' => array(),

            // Labels
            'subLabel' => '',
            'subLabelAbove' => '',
            'tooltip' => '',
            'tooltipType' => 'icon',
            'tooltipEvent' => 'inherit',
            'labelPosition' => 'inherit',
            'labelWidth' => '',

            // Logic
            'logicEnabled' => false,
            'logicAction' => true,
            'logicMatch' => 'all',
            'logicRules' => array(),

            // Advanced
            'visibility' => '',

            // Translations
            'messageRequired' => '',
            'messageRecaptchaMissingInputSecret' => '',
            'messageRecaptchaInvalidInputSecret' => '',
            'messageRecaptchaMissingInputResponse' => '',
            'messageRecaptchaInvalidInputResponse' => '',
            'messageRecaptchaError' => ''
        ));

        $config['type'] = 'recaptcha';

        if (Quform::isNonEmptyString($key)) {
            return Quform::get($config, $key);
        }

        return $config;
    }
}
