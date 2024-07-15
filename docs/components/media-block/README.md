# Media Block

A reusable HTML media block to standardize rendering, improve maintainability, and ensure consistent styling and functionality across the project.

## Usage

Use the `wplite:media-block` VSCode snippet to quickly insert media block HTML markup.

## Example

```phtml
<div class="row align-items-center ">
  <div class="col-12 col-lg-6 mb-4 mb-lg-0">
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
  </div>
  <div class="col-12 col-lg-6">
    <div class="col-lg-10 mx-auto">
      <h2 class="mb-3 display-6 fw-bold">Lorem ipsum</h2>
      <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
      <a
        href="https://"
        class="btn btn-primary mt-3"
        role="button"
        alt="Read more"
        aria-label="Read more about this">
        Read more
      </a>
    </div>
  </div>
</div>
```

## Useful Links:

- [Bootstrap](https://getbootstrap.com/) > [Containers](https://getbootstrap.com/docs/5.3/layout/containers/)
- [Bootstrap](https://getbootstrap.com/) > [Images](https://getbootstrap.com/docs/5.3/content/images/)
- [Bootstrap](https://getbootstrap.com/) > [Buttons](https://getbootstrap.com/docs/5.3/components/buttons/)
- [MDN Web Docs](https://developer.mozilla.org/en-US/) > [Responsive Images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images)
