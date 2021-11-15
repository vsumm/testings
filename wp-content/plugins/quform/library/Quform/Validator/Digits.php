<?php

/**
 * @copyright Copyright (c) 2009-2020 ThemeCatcher (https://www.themecatcher.net)
 */
class Quform_Validator_Digits extends Quform_Validator_Abstract
{
    const INVALID = 'digitsInvalid';
    const NOT_DIGITS = 'notDigits';

    /**
     * Digits filter used for validation
     *
     * @var Quform_Filter_Digits
     */
    protected static $filter = null;

    /**
     * Returns true if the given value contains only digits.
     * Return false otherwise.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->reset();

        if ( ! is_string($value)) {
            $this->error(self::INVALID);
            return false;
        }

        if (self::$filter === null) {
            self::$filter = new Quform_Filter_Digits;
        }

        self::$filter->setConfig('allowWhiteSpace', $this->config('allowWhiteSpace'));

        if ($value !== self::$filter->filter($value)) {
            $this->error(self::NOT_DIGITS, compact('value'));
            return false;
        }

        return true;
    }

    /**
     * Get all message templates or the single message with the given key
     *
     * @param   string|null   $key
     * @return  array|string
     */
    public static function getMessageTemplates($key = null)
    {
        $messageTemplates = array(
            self::INVALID => __('Invalid data type, string expected',  'quform'),
            self::NOT_DIGITS => __('Only digits are allowed',  'quform')
        );

        if (is_string($key)) {
            return array_key_exists($key, $messageTemplates) ? $messageTemplates[$key] : null;
        }

        return $messageTemplates;
    }

    /**
     * Get the default config for this validator
     *
     * @param   string|null  $key  Get the config by key, if omitted the full config is returned
     * @return  array
     */
    public static function getDefaultConfig($key = null)
    {
        $config = apply_filters('quform_default_config_validator_digits', array(
            'allowWhiteSpace' => false,
            'messages' => array(
                self::INVALID => '',
                self::NOT_DIGITS => ''
            )
        ));

        $config['type'] = 'digits';

        if (Quform::isNonEmptyString($key)) {
            return Quform::get($config, $key);
        }

        return $config;
    }
}
