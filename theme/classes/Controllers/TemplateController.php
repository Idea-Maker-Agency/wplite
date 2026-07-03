<?php

namespace WPLite\Controllers;

use WPLite\Utils\CustomFields;

defined('ABSPATH') || exit;

class TemplateController
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    add_filter('frontpage_template', [$this, 'load_page_template'], 10, 3);
    add_filter('home_template', [$this, 'load_page_template'], 10, 3);
    add_filter('page_template', [$this, 'load_page_template'], 10, 3);
    add_filter('privacypolicy_template', [$this, 'load_page_template'], 10, 3);
    add_filter('search_template', [$this, 'load_page_template'], 10, 3);
    add_filter('404_template', [$this, 'load_page_template'], 10, 3);

    add_filter('single_template', [$this, 'load_single_template'], 10, 3);
    add_filter('singular_template', [$this, 'load_single_template'], 10, 1);

    add_filter('archive_template', [$this, 'load_archive_template'], 10, 1);

    add_filter('category_template', [$this, 'load_category_template'], 10, 3);

    add_filter('tag_template', [$this, 'load_tag_template'], 10, 3);

    add_action('admin_init', [$this, 'init_custom_fields']);
    add_filter('theme_page_templates', [$this, 'page_templates'], 10, 3);

    add_filter('get_the_archive_title', [$this, 'archive_title_output'], 10, 3);
    add_filter('get_search_form', [$this, 'search_form_output'], 10, 2);
    add_filter('paginate_links_output', [$this, 'paginate_links_output'], 10, 2);
  }

  /**
   * Loads custom page templates file.
   *
   * @param  string $template
   * @param  string $type
   * @param  array  $templates
   * @return string
   */
  public function load_page_template(string $template, string $type, array $templates): string
  {
    global $post;

    if (is_front_page()) {
      $custom_template = locate_template("templates/page/front-page/front-page.php");
    } elseif (is_home()) {
      $custom_template = locate_template("templates/archive/post/archive-post.php");
    } elseif (is_search()) {
      $custom_template = locate_template("templates/page/search/search.php");
    } elseif (is_404()) {
      $custom_template = locate_template("templates/page/404/404.php");
    } else {
      $ancestors = get_post_ancestors($post);

      $nested_path = array_reduce(
        array_reverse($ancestors),
        function (string $path, int $ancestor_id) {
          $slug = get_post_field('post_name', $ancestor_id);

          $path = "{$slug}/{$path}";

          return $path;
        },
        $post->post_name
      );

      // E.g. `templates/page/<parent>/<slug>/<slug>.php`
      $custom_template = locate_template("templates/page/{$nested_path}/{$post->post_name}.php");

      if (! $custom_template) {
        // E.g. `templates/page/<slug>/<slug>.php`
        $custom_template = locate_template("templates/page/{$post->post_name}/{$post->post_name}.php");
      }
    }

    return $custom_template ?: $template;
  }

  /**
   * Loads custom single templates file.
   *
   * @param  string $template
   * @return string
   */
  public function load_single_template(string $template): string
  {
    global $post;

    // E.g. `templates/single-<post_type>/single-<post_type>.php`
    $custom_template = locate_template("templates/single/{$post->post_type}/single-{$post->post_type}.php");

    return $custom_template ?: $template;
  }

  /**
   * Loads custom archive templates file.
   *
   * @param  string $template
   * @return string
   */
  public function load_archive_template(string $template): string
  {
    $post_type = get_queried_object()->name ?? '';

    // E.g. `templates/archive/<post_type>/<post_type>.php`
    $custom_template = locate_template("templates/archive/{$post_type}/archive-{$post_type}.php");

    return $custom_template ?: $template;
  }

  /**
   * Loads custom category templates file.
   *
   * @param  string $template
   * @return string
   */
  public function load_category_template(string $template): string
  {
    $slug = get_queried_object()->slug ?? '';

    $custom_template = locate_template("templates/taxonomy/category/taxonomy-category.php");

    return $custom_template ?: $template;
  }

  /**
   * Loads custom tag templates file.
   *
   * @param  string $template
   * @return string
   */
  public function load_tag_template(string $template): string
  {
    $slug = get_queried_object()->slug ?? '';

    $custom_template = locate_template("templates/taxonomy/post_tag/taxonomy-post_tag.php");

    return $custom_template ?: $template;
  }

  /**
   * Init custom fields.
   */
  public function init_custom_fields()
  {
    $id     = (int) $_GET['post'] ?? 0;
    $action = $_POST['action']    ?? null;

    $front_page_id = get_option('page_on_front');

    if (! $id && 'editpost' === $action) {
      $id = (int) $_POST['post_ID'] ?? 0;
    }

    if (! $id) {
      return;
    }

    $page_template = get_post_meta($id, '_wp_page_template', true);

    if ($front_page_id == $id) {
      $json_file = locate_template("templates/page/front-page/front-page.json");

      remove_post_type_support('page', 'editor');
    } else {
      $post_type = get_post_field('post_type', $id);
      $post_name = get_post_field('post_name', $id);

      if (empty($page_template) || 'default' === $page_template) {
        if ('page' === $post_type) {
          $ancestors = get_post_ancestors($id);

          $nested_path = array_reduce(
            array_reverse($ancestors),
            function (string $path, int $ancestor_id) {
              $slug = get_post_field('post_name', $ancestor_id);

              $path = "{$slug}/{$path}";

              return $path;
            },
            $post_name
          );

          $page_template = locate_template("templates/page/{$nested_path}/{$post_name}.php");

          if (! $page_template) {
            $page_template = locate_template("templates/page/{$post_name}/{$post_name}.php");
          }
        } else {
          $page_template = locate_template("templates/single/{$post_type}/single-{$post_type}.php");
        }

        $json_file = str_replace('.php', '.json', $page_template);
      } else {
        $json_file = locate_template(str_replace('.php', '.json', $page_template));
      }

      if ('page' === $post_type) {
        remove_post_type_support('page', 'editor');
      }
    }

    if (! $json_file) {
      return;
    }

    $json_contents = file_get_contents($json_file);
    $json_groups   = json_decode($json_contents, true);

    if (empty($json_groups)) {
      return;
    }

    $custom_fields = new CustomFields();

    $custom_fields->set_groups($json_groups);
    $custom_fields->init();
  }

  /**
   * Filters list of page templates.
   *
   * @param  array     $page_templates
   * @param  \WP_Theme $theme
   * @param  mixed     $post
   * @return array
   */
  public function page_templates(array $page_templates, \WP_Theme $theme, mixed $post): array
  {
    $path = get_theme_file_path('page-templates');
    $dir  = scandir($path);

    if ($dir) {
      $subdir = array_filter($dir, function ($subdir) use ($path) {
        if (in_array($subdir, ['.', '..'])) {
          return false;
        }

        return is_dir($path . '/' . $subdir);
      });

      $subdir_keys = array_map(function ($value) {
        return 'page-templates/' . $value . '/' . $value . '.php';
      }, $subdir);

      $subdir_names = array_map(function ($value, $key) {
        $file_path = get_theme_file_path($key);

        if (!file_exists($file_path)) {
          return '';
        }

        $file_contents = file_get_contents($file_path);

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
   * @param  string $title
   * @param  string $orig_title
   * @param  string $prefix
   * @return string
   */
  public function archive_title_output(string $title, string $orig_title, string $prefix): string
  {
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
   * @param  string $form
   * @param  array  $args
   * @return string
   */
  public function search_form_output(string $form, array $args): string
  {
    $form = str_replace('type="text"', 'type="text" class="form-control"', $form);
    $form = str_replace('type="submit"', 'type="submit" class="btn btn-secondary mt-2"', $form);

    return $form;
  }

  /**
   * Filters the HTML output of paginated links for archives.
   *
   * @param  string $output
   * @param  array  $args
   * @return string
   */
  public function paginate_links_output(string $output, array $args): string
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
