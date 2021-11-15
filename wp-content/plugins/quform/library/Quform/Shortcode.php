<?php

/**
 * @copyright Copyright (c) 2009-2020 ThemeCatcher (https://www.themecatcher.net)
 */
class Quform_Shortcode
{
    /**
     * @var Quform_Form_Controller
     */
    protected $controller;

    /**
     * @var Quform_Options
     */
    protected $options;

    /**
     * @param Quform_Form_Controller $controller
     * @param Quform_Options $options
     */
    public function __construct(Quform_Form_Controller $controller, Quform_Options $options)
    {
        $this->controller = $controller;
        $this->options = $options;
    }

    /**
     * Handle the [quform] shortcode to display a form
     *
     * @param   array   $attributes  The shortcode attributes
     * @return  string               The form HTML
     */
    public function form($attributes)
    {
        $options = shortcode_atts(array(
            'id' => '',
            'values' => '',
            'show_title' => '1',
            'show_description' => '1'
        ), $attributes);

        $options['show_title'] = $options['show_title'] == '1';
        $options['show_description'] = $options['show_description'] == '1';

        $output = $this->controller->form($options);

        if ($this->options->get('rawFix')) {
            $output = '[raw]' . $output . '[/raw]';
        }

        return $output;
    }

    /**
     * Handle the [quform_popup] shortcode to display a form
     *
     * @param   array   $attributes  The shortcode attributes
     * @param   string  $content     The content between shortcode tags
     * @return  string               The form HTML
     */
    public function popup($attributes, $content = '')
    {
        $options = shortcode_atts(array(
            'id' => '',
            'values' => '',
            'options' => '',
            'width' => '',
            'show_title' => '1',
            'show_description' => '1'
        ), $attributes);

        $options['show_title'] = $options['show_title'] == '1';
        $options['show_description'] = $options['show_description'] == '1';
        $options['popup'] = true;
        $options['content'] = $content;

        $output = $this->controller->form($options);

        if ($this->options->get('rawFix')) {
            $output = '[raw]' . $output . '[/raw]';
        }

        return $output;
    }
}
