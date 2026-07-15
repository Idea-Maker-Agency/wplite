<?php

/**
 * Filters the maximum number of words in a post excerpt.
 *
 * @param  int $length
 * @return int
 */
function wplite_excerpt_length(int $length): int {
    return 14;
}
add_filter('excerpt_length', 'wplite_excerpt_length', 999);

/**
 * Filters the string in the “more” link displayed after a trimmed excerpt.
 *
 * @param  string $more
 * @return string
 */
function wplite_excerpt_more(string $more): string {
    return '...';
}
add_filter('excerpt_more', 'wplite_excerpt_more', 999);