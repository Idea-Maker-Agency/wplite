<?php

namespace WPLite\Controllers;

if (! defined('ABSPATH')) die;

use WPCF7_ContactForm;

class ContactForm7Controller
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_filter('wpcf7_autop_or_not', '__return_false');
    add_filter('wpcf7_form_tag', [self::class, 'form_tags'], 10, 2);
    add_filter('wpcf7_default_template', [self::class, 'default_template'], 10, 2);
    add_filter('wpcf7_form_response_output', [self::class, 'response_output'], 10, 5);
  }

  /**
   * Filters form tags.
   *
   * @since 1.0.0
   *
   * @param array     $form_tag   Form tags array.
   * @param string    $replace    Form tags replacement string.
   *
   * @return array
   */
  public static function form_tags(array $form_tag, string $replace): array
  {
    if (
      in_array($form_tag['basetype'], ['text', 'email', 'textarea'])
    ) {
      $form_tag['options'][] = 'class:form-control';
    } elseif ('submit' === $form_tag['basetype']) {
      $form_tag['options'][] = 'class:btn';
      $form_tag['options'][] = 'class:btn-primary';
    }

    return $form_tag;
  }

  /**
   * Filters default template.
   *
   * @since 1.0.0
   *
   * @param string    $template   Form default template HTML markup.
   * @param string    $prop       Form template type.
   *
   * @return string
   */
  public static function default_template(mixed $template, string $prop): mixed
  {
    if ('form' === $prop) {
      $template = sprintf(
        "<div class=\"%12\$s\">\n".
          "\t<label for=\"%3\$s\" class=\"%11\$s\">%2\$s</label>\n".
          "\t[text* your-name id:%3\$s autocomplete:name]\n".
        "</div>\n\n".

        "<div class=\"%12\$s\">\n".
          "\t<label for=\"%5\$s\" class=\"%11\$s\">%4\$s</label>\n".
          "\t[email* your-email id:%5\$s autocomplete:email]\n".
        "</div>\n\n".

        "<div class=\"%12\$s\">\n".
          "\t<label for=\"%7\$s\" class=\"%11\$s\">%6\$s</label>\n".
          "\t[text* your-subject id:%7\$s]\n".
        "</div>\n\n".

        "<div class=\"%12\$s\">\n".
          "\t<label for=\"%9\$s\" class=\"%11\$s\">%8\$s</label>\n".
          "\t[textarea your-message id:%9\$s]\n".
        "</div>\n\n".

        "<div class=\"position-relative d-inline-block\">\n".
        "\t[submit \"%10\$s\"]\n".
        "</div>",

        __('(optional)', THEME_TEXT_DOMAIN),

        __('Your name', THEME_TEXT_DOMAIN),
        __('id_your-name', THEME_TEXT_DOMAIN),

        __('Your email', THEME_TEXT_DOMAIN),
        __('id_your-email', THEME_TEXT_DOMAIN),

        __('Subject', THEME_TEXT_DOMAIN),
        __('id_subject', THEME_TEXT_DOMAIN),

        __('Your message', THEME_TEXT_DOMAIN),
        __('id_message', THEME_TEXT_DOMAIN),

        __('Submit', THEME_TEXT_DOMAIN),

        'form-label small',
        'mb-3'
      );

      return trim($template);
    }

    return $template;
  }

  /**
   * Filters form response output.
   *
   * @param string    $output     Form response output HTML.
   * @param string    $class      Form response CSS class.
   * @param string    $content    Form response content.
   * @param WPCF7_ContactForm $wpcf7 The WPCF7_ContactForm object.
   * @param string    $status     Form response status.
   *
   * @return string
   */
  public static function response_output(
    string $output,
    string $class,
    string $content,
    WPCF7_ContactForm $wpcf7,
    string $status
  ): string {
    $classes = wp_parse_args(
      ['alert', 'alert-warning', 'py-2', 'px-3', 'mx-0', 'border-0',],
      [$class,]
    );

    $atts = [
      'class' => implode(' ', $classes),
      'aria-hidden' => 'true',
    ];

    return sprintf(
      '<div %1$s>%2$s</div>',
      wpcf7_format_atts($atts),
      esc_html($content)
    );
  }
}
