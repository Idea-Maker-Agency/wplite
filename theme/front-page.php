<?php
/**
 * The template for displaying front-page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

get_header();
?>

<section class="hero-banner text-light bg-primary py-5 text-center d-flex align-items-center">
  <div class="container py-lg-5 px-lg-4">
    <h1 class="hero-banner__heading mb-4 fw-bold">Lorem ipsum dolor sit amet</h1>
    <div class="col-10 col-sm-9 col-lg-6 mx-auto">
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
      <div class="hero-banner__actions mt-4 mt-lg-5 d-grid gap-2 d-sm-flex justify-content-sm-center">
      <a
        class="btn btn-light"
        role="button"
        title="Get Started">
        Get Started
      </a>
      <a
        class="btn btn-outline-light"
        role="button"
        title="Learn More">
        Learn More
      </a>
      </div>
    </div>
  </div>
</section>

<section
  id=""
  class="py-5">
  <div class="container">
    <div class="row align-items-center ">
      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <img
          src="https://placehold.co/640x480"
          srcset="
            https://placehold.co/640x480 640w,
            https://placehold.co/320x240 320w"
          sizes="(min-width: 960px) 640px, 100vw"
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
          class="btn btn-primary mt-3"
            role="button"
            alt="Read more"
            aria-label="Read more about this">
            Read more
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
