<?php

namespace Shazkho\BootstrapHelper;

use Form;
use Html;

class BootstrapHelper
{

    /**
     * Generates a div container with a label and a TEXT input inside, as used with Bootstrap css.
     * It uses the general form
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $value
     * @param array $options
     * @return string
     */
    public static function text($name, $label, $placeholder='', $value='', $options=[])
    {
        return self::bootstrap_field('text', $name, $label, $placeholder, $value, $options);
    }


    /**
     * Generates a div container with a label and a EMAIL input inside, as used with Bootstrap css
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $value
     * @param array $options
     * @return string
     */
    public static function email($name, $label, $placeholder='', $value='', $options=[])
    {
        return self::bootstrap_field('email', $name, $label, $placeholder, $value, $options);
    }


    /**
     * Takes an options array and a desired style and puts the basic button classes, as used in Bootstrap.
     *
     * @param string    $style
     * @param array     $options
     * @return mixed
     */
    private static function basic_buttonry($style, $options)
    {
        $basic_classes = preg_replace('/(.*)%STYLE%(.*)/', '$1' . $style . '$2', 'btn btn-%STYLE%');
        if(empty($options['class'])) {
            $options['class'] = $basic_classes;
        } else {
            $options['class'] .= ' ' . $basic_classes;
        }
        return $options;
    }


    /**
     * Generates a submit button using <input type="submit"> tag, as used with Bootstrap css.
     *
     * @param string    $value
     * @param string    $style
     * @param array     $options
     * @return \Illuminate\Support\HtmlString
     */
    public static function submit($value, $style='primary', $options=[])
    {
        $options = self::basic_buttonry($style, $options);
        return  Form::submit($value, $options);
    }


    /**
     * Generates a button using <a> tag, as used with Bootstrap css.
     *
     * @param string $value
     * @param string $style
     * @param array $options
     * @param bool $url
     * @return \Illuminate\Support\HtmlString
     */
    public static function button($value, $style='primary', $options=[], $url=False)
    {
        $options = self::basic_buttonry($style, $options);
        return Html::link($url? $url: '', $value, $options);
    }


    /**
     * @param string $tag
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $value
     * @param array $options
     * @return string
     */
    private static function bootstrap_field($tag, $name, $label, $placeholder='', $value='', $options=[])
    {
        $html = '<div class="form-group">' . Form::label($name, $label);
        $html .=  Form::{$tag}($name, $value, array_merge(['class' => 'form-control', 'placeholder' => $placeholder], $options));
        return $html .= '</div>';
    }

}