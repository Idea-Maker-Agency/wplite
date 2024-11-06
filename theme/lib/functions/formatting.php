<?php

/**
 * Filters the maximum number of words in a post excerpt.
 *
 * @since 1.0.0
 *
 * @param int $length The maximum number of words.
 * @return int
 */
add_filter('excerpt_length', 'wplite_excerpt_length', 999);
function wplite_excerpt_length(int $length): int
{
  return 14;
}

/**
 * Filters the string in the “more” link displayed after a trimmed excerpt.
 *
 * @since 1.0.0
 *
 * @param string $more The string shown within the more link.
 * @return string
 */
add_filter('excerpt_more', 'wplite_excerpt_more', 999);
function wplite_excerpt_more(string $more): string
{
  return '...';
}
