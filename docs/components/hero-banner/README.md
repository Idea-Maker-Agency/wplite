# Hero Banner

A reusable HTML hero banner to standardize rendering, improve maintainability, and ensure consistent styling and functionality across the project.

## Usage

Use the `wplite:hero-banner` VSCode snippet to quickly insert hero banner HTML markup.

## Example

```phtml
<section class="hero-banner text-white py-5 text-center d-flex align-items-center position-relative">
  <div class="container py-lg-5 px-lg-4 position-relative z-1">
    <div class="row">
      <div class="col-10 col-sm-9 col-lg-6 mx-auto">
        <h1 class="hero-banner__heading mb-4 fw-bold">Lorem ipsum dolor sit amet</h1>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        <div class="hero-banner__actions mt-4 mt-lg-5 d-grid gap-2 d-sm-flex justify-content-sm-center">
          <a
            href="https://"
            class="btn btn-primary"
            rel="nofollow noopener noreferrer"
            alt="Get Started"
            aria-label="Get Started" >
            Get Started
          </a>
          <a
            href="https://"
            class="btn btn-outline-primary"
            rel="nofollow noopener noreferrer"
            alt="Learn More"
            aria-label="Learn More" >
            Learn More
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="w-100 h-100 bg-dark bg-opacity-50 position-absolute top-0 start-0 z-n2"></div>
  <img
    src="<?php echo wplite_get_webp_url( 'hero', '', [ 1920, 1080 ] ) ?>"
    srcset="
      <?php echo wplite_get_webp_url( 'hero', '', [ 1920, 1080 ] ) ?> 1920w,
      <?php echo wplite_get_webp_url( 'hero', '', [ 1024, 768 ] ) ?> 1024w,
      <?php echo wplite_get_webp_url( 'hero', '', [ 320, 500 ] ) ?> 320w"
    sizes="(min-width: 1920px) 1920px, (min-width: 1024px) 1024px, 100vw"
    width="1920"
    height="1080"
    alt="Hero image"
    decoding="async"
    class="w-100 h-100 object-fit-cover position-absolute top-0 start-0 z-n1" />
</section>
```

## Useful Links:

- [Bootstrap](https://getbootstrap.com/) > [Containers](https://getbootstrap.com/docs/5.3/layout/containers/)
- [MDN Web Docs](https://developer.mozilla.org/en-US/) > [Responsive Images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images)
