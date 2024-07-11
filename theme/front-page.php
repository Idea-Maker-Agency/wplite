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

<section
  id=""
  class="bg-light py-5">
  <div class="container">
    <div class="mb-5 text-center">
      <h2 class="display-5 fw-bold">Features</h2>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
    </div>

    <div class="row row-cols-1 row-cols-lg-3 g-4">
      <div class="feature col">
        <img
          src="https://placehold.co/75x75/125997/ffffff/svg"
          width="75"
          height="75"
          alt="Alt text"
          loading="lazy"
          decoding="async"
          class="feature__icon img-fluid mb-4 rounded-circle" />
        <h3 class="feature__heading fw-bold">Lorem ipsum</h3>
        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        <a
          href="https://"
          class="feature__link"
          rel="noopener noreferrer"
          alt="Read more"
          aria-label="Read more about Lorem ipsum" >
          Read more
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>
        </a>
      </div>
      <div class="feature col">
        <img
          src="https://placehold.co/75x75/125997/ffffff/svg"
          width="75"
          height="75"
          alt="Alt text"
          loading="lazy"
          decoding="async"
          class="feature__icon img-fluid mb-4 rounded-circle" />
        <h3 class="feature__heading fw-bold">Lorem ipsum</h3>
        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        <a
          href="https://"
          class="feature__link"
          rel="noopener noreferrer"
          alt="Read more"
          aria-label="Read more about Lorem ipsum" >
          Read more
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>
        </a>
      </div>
      <div class="feature col">
        <img
          src="https://placehold.co/75x75/125997/ffffff/svg"
          width="75"
          height="75"
          alt="Alt text"
          loading="lazy"
          decoding="async"
          class="feature__icon img-fluid mb-4 rounded-circle" />
        <h3 class="feature__heading fw-bold">Lorem ipsum</h3>
        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        <a
          href="https://"
          class="feature__link"
          rel="noopener noreferrer"
          alt="Read more"
          aria-label="Read more about Lorem ipsum" >
          Read more
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
