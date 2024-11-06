<?php
/**
 * The template for displaying comments.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

if (have_comments()) {
?>
  <div
    id="comments"
    class="mt-4 mt-lg-5">
    <h4 class="mb-3 fw-bold">Comments</h4>

    <div>
      <?php wp_list_comments([
        'style' => 'div',
        'short_ping' => true,
        'avatar_size' => 32,
      ]) ?>
    </div>
  </div>
<?php } ?>

<?php
comment_form([
  'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title mb-3 fw-bold">',
  'title_reply_after' => '</h4>',
  'comment_field' => sprintf(
    '<p class="comment-form-comment">%s %s</p>',
    sprintf(
      '<label for="comment" class="form-label small">%s %s</label>',
      _x('Comment', 'noun'),
      wp_required_field_indicator()
    ),
    '<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" maxlength="65525" required></textarea>'
  ),
  'class_container' => 'comment-respond pt-4 mt-4 border-top border-top-light',
  'class_submit' => 'btn btn-secondary',
]);
