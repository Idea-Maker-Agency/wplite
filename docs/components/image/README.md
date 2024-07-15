# Image

A reusable HTML image component to standardize rendering, improve maintainability, and ensure consistent styling and functionality across the project.

## Usage

Use the `wplite:image` VSCode snippet to quickly insert optimized image tags with responsive attributes in your code.

## Example

```phtml
<img
  src="<?php echo wplite_get_webp_url( 'placeholder', '', [ 640, 480 ] ) ?>"
  srcset="
    <?php echo wplite_get_webp_url( 'placeholder', '', [ 640, 480 ] ) ?> 640w,
    <?php echo wplite_get_webp_url( 'placeholder', '', [ 540, 360 ] ) ?> 540w,
    <?php echo wplite_get_webp_url( 'placeholder', '', [ 320, 230 ] ) ?> 320w"
  sizes="(min-width: 640px) 640px, (min-width: 540px) 540px, 100vw"
  width="640"
  height="480"
  alt="Alt text"
  loading="lazy"
  decoding="async"
  class="img-fluid rounded-4" />
```

## Important Notes:

Don't lazy load images that appear "above the fold", just use a standard `<img>` or `<picture>` element. If using the VSCode `wplite:image` code snippet, just remove the `loading="lazy"` line.

> Why? LCP (Largest Contentful Paint) measures the moment when the largest visible content on the page is rendered. If you employ lazy loading and the images are visible "above the fold" (without the need to scroll) and are the largest content on the page, they will be considered in the LCP metric. This can also apply if only a portion of the image, such as the top, is visible.

## Useful Links:

- [TinyPNG](https://tinypng.com/): Used for optimizing and generate webp version of the image.
- [Bootstrap](https://getbootstrap.com/) > [Images](https://getbootstrap.com/docs/5.3/content/images/)
- [MDN Web Docs](https://developer.mozilla.org/en-US/) > [Responsive Images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images)
