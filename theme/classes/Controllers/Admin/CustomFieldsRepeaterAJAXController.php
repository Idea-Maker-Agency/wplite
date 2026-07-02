<?php

namespace WPLite\Controllers\Admin;

use WPLite\Utils\CustomFields;

defined('ABSPATH') || exit;

class CustomFieldsRepeaterAJAXController
{
    /**
     * Init.
     *
     * @return void
     */
    public static function init(): void
    {
        add_action('wp_ajax_custom_fields__repeater_add', [self::class, 'add'], 10);
        add_action('wp_ajax_custom_fields__repeater_remove', [self::class, 'remove'], 10);
    }

    /**
     * Add new field.
     *
     * @return void
     */
    public static function add(): void
    {
        $post_id = (int) $_POST['post_id'] ?: 0;
        $name    = $_POST['name']  ?? '';
        $index   = $_POST['index'] ?? 0;
        $fields  = json_decode(stripslashes($_POST['fields'] ?? ''), true);
        $keys    = json_decode(stripslashes($_POST['keys'] ?? ''), true);

        $key = $keys[count($keys) - 1];
        ?>
    <div id="repeater-fields-<?= $name ?>">
      <?php get_template_part('classes/Views/CustomFields/repeater', 'item', [
            'post_id' => $post_id,
            'name'    => $name,
            'index'   => $index,
            'key'     => $key,
            'fields'  => $fields,
          ]) ?>
    </div>
    <?php
        wp_die();
    }

    /**
     * Remove field.
     *
     * @return void
     */
    public static function remove(): void
    {
        global $wpdb;

        $post_id = (int) $_POST['post_id'] ?: 0;
        $name    = $_POST['name'] ?? '';
        $key     = $_POST['key']  ?? '';

        // Delete meta datas if exists
        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_key FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key LIKE %s",
                $post_id,
                $wpdb->esc_like($key) . '%'
            )
        );

        if (! empty($results)) {
            foreach ($results as $result) {
                delete_post_meta($post_id, $result->meta_key);
            }
        }

        // Remove key from keys meta data
        $keys = get_post_meta($post_id, "{$name}_keys", true) ?: [];

        $index = array_search($key, $keys);

        if (false !== $index) {
            unset($keys[$index]);

            if (! empty($keys)) {
                update_post_meta($post_id, "{$name}_keys", $keys);
            } else {
                delete_post_meta($post_id, "{$name}_keys");
            }
        }

        echo '';

        wp_die();
    }
}
