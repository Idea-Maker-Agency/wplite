<?php

namespace WPLite\Controllers;

if (! defined('ABSPATH')) die;

use WP_Theme, WP_Post;
use Spyc;
use WPLite\Utils\CustomFields;

class TemplateController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_filter('page_template', [self::class, 'load_template'], 10, 3);
    add_action('admin_init', [self::class, 'init_custom_fields']);
    add_filter('theme_page_templates', [self::class, 'page_templates'], 10, 3);

    add_filter('get_the_archive_title', [self::class, 'archive_title_output'], 10, 3);
    add_filter('get_search_form', [self::class, 'search_form_output'], 10, 2);
    add_filter('paginate_links_output', [self::class, 'paginate_links_output'], 10, 2);
  }

  /**
   * Fires after a user is logged out.
   *
   * @return mixed
   */
  public static function load_template(
    string $template,
    string $type,
    array $templates
  ): mixed {
    global $post;

    if (is_front_page()) {
      $view_template = locate_template("pages/front-page/front-page.php");
    } else {
      $view_template = locate_template("pages/{$post->post_name}/{$post->post_name}.php");
    }

    return $view_template ?: $template;
  }

  /**
   * Init custom fields.
   *
   * @return void
   */
  public static function init_custom_fields(): void
  {
    $id = intval($_GET['post'] ?? 0);
    $action = $_POST['action'] ?? null;

    $front_page_id = get_option('page_on_front');

    if (! $id && 'editpost' === $action) {
      $id = intval($_POST['post_ID'] ?? 0);
    }

    if (! $id) return;

    $page_template = get_post_meta($id, '_wp_page_template', true);

    if ($front_page_id == $id) {
      $fields = locate_template("pages/front-page/front-page.yaml");
    } else {
      $slug = get_post_field('post_name', $id);

      if ('default' === $page_template) {
        $page_template = locate_template("pages/{$slug}/{$slug}.php");

        if (! $page_template) {
          $page_template = locate_template("page-{$slug}.php");
        }
      }

      $fields = locate_template(str_replace('.php', '.yaml', $page_template));
    }

    if (! $fields) return;

    $load_fields = Spyc::YAMLLoad($fields);

    if (empty($load_fields)) return;

    $custom_fields = new CustomFields();

    $custom_fields->set_fields($load_fields);
    $custom_fields->init();

    remove_post_type_support('page', 'editor');
  }

  /**
   * Filters list of page templates.
   *
   * @param array     $page_templates   Array of page templates. Keys are filenames, values are translated names.
   * @param WP_Theme  $theme            The theme object.
   * @param WP_Post   $post             The post being edited, provided for context, or null.
   *
   * @return array
   */
  public static function page_templates(
    array $page_templates,
    WP_Theme $theme,
    WP_Post | null $post
  ): array {
    $path = THEME_DIR_PATH . '/page-templates';
    $dir = scandir($path);

    if ($dir) {
      $subdir = array_filter($dir, function ($subdir) use ($path) {
        if (in_array($subdir, ['.', '..'])) return false;

        return is_dir($path . '/' . $subdir);
      } );

      $subdir_keys = array_map(function ($value) {
        return 'page-templates/' . $value . '/' . $value . '.php';
      }, $subdir);

      $subdir_names = array_map(function ($value, $key) {
        $file_contents = file_get_contents(get_theme_file_path($key));

        if (preg_match('|Template Name:(.*)$|mi', $file_contents, $type)) {
          return _cleanup_header_comment($type[1]);
        }

        return $value;
      }, $subdir, $subdir_keys);

      $subdir_items = array_combine($subdir_keys, $subdir_names);

      if (! empty($subdir_items)) {
        $page_templates = array_merge($page_templates, $subdir_items);
      }
    }

    return $page_templates;
  }

  /**
   * Filters the archive title.
   *
   * @since 1.0.0
   *
   * @param string $title Archive title to be displayed.
   * @param string $orig_title Archive title without prefix.
   * @param string $prefix Archive title prefix.
   *
   * @return string
   */
  function archive_title_output(
    string $title,
    string $orig_title,
    string $prefix
  ): string {
    if (! empty($prefix)) {
      return sprintf(
        _x('%1$s %2$s', 'archive title'),
        '<span class="mb-2 fs-6 fw-normal text-uppercase d-block">' . preg_replace('/:$/', '', $prefix) . '</span>',
        $orig_title
      );
    }

    return $orig_title;
  }

  /**
   * Filters the HTML output of the search form.
   *
   * @param string $form The search form HTML output.
   * @param array $args The array of arguments for building the search form.
   *
   * @return string
   */
  public static function search_form_output(string $form, array $args): string
  {
    $form = str_replace('type="text"', 'type="text" class="form-control"', $form);
    $form = str_replace('type="submit"', 'type="submit" class="btn btn-secondary mt-2"', $form);

    return $form;
  }

  /**
   * Filters the HTML output of paginated links for archives.
   *
   * @since 1.0.0
   *
   * @param string    $output   HTML output.
   * @param array     $args     An array of arguments. See `paginate_links()` for information on accepted arguments.
   *
   * @return string
   */
  public static function paginate_links_output(string $output, array $args): string
  {
    if ('list' === $args['type']) {
      $output = str_replace("<ul class='page-numbers'", "<ul class='pagination mb-0 justify-content-center'", $output);
      $output = str_replace("<li", "<li class='page-item'", $output);
      $output = str_replace("page-numbers", "page-link", $output);
      $output = str_replace("current", "active", $output);
    }

    return $output;
  }
}
