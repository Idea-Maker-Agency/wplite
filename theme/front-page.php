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
            class="btn btn-outline-light"
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
    src="<?php echo wplite_get_webp_url('hero', '', [1920, 1080]) ?>"
    srcset="
      <?php echo wplite_get_webp_url('hero', '', [1920, 1080]) ?> 1920w,
      <?php echo wplite_get_webp_url('hero', '', [1024, 768]) ?> 1024w,
      <?php echo wplite_get_webp_url('hero', '', [320, 500]) ?> 320w"
    sizes="(min-width: 1920px) 1920px, (min-width: 1024px) 1024px, 100vw"
    width="1920"
    height="1080"
    alt="Hero image"
    decoding="async"
    class="w-100 h-100 object-fit-cover position-absolute top-0 start-0 z-n1" />
</section>

<section
  id=""
  class="py-5">
  <div class="container">
    <div class="row align-items-center ">
      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <img
          src="<?php echo wplite_get_webp_url('placeholder', '', [640, 480]) ?>"
          srcset="
            <?php echo wplite_get_webp_url('placeholder', '', [640, 480]) ?> 640w,
            <?php echo wplite_get_webp_url('placeholder', '', [540, 360]) ?> 540w,
            <?php echo wplite_get_webp_url('placeholder', '', [320, 230]) ?> 320w"
          sizes="(min-width: 640px) 640px, (min-width: 540px) 540px, 100vw"
          width="640"
          height="480"
          alt="Alt text"
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
          src="<?php echo wplite_get_webp_url('placeholder', '', [75, 75]) ?>"
          width="75"
          height="75"
          alt="Alt text"
          decoding="async"
          class="feature__icon img-fluid mb-2" />
        <h3 class="feature__heading fw-bold">Lorem ipsum</h3>
        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        <a
          href="https://"
          class="feature__link text-decoration-none fw-bold"
          rel="noopener noreferrer"
          alt="Read more"
          aria-label="Read more about Lorem ipsum" >
          Read more
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>
        </a>
      </div>
      <div class="feature col">
        <img
          src="<?php echo wplite_get_webp_url('placeholder', '', [75, 75]) ?>"
          width="75"
          height="75"
          alt="Alt text"
          loading="lazy"
          decoding="async"
          class="feature__icon img-fluid mb-2" />
        <h3 class="feature__heading fw-bold">Lorem ipsum</h3>
        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        <a
          href="https://"
          class="feature__link text-decoration-none fw-bold"
          rel="noopener noreferrer"
          alt="Read more"
          aria-label="Read more about Lorem ipsum" >
          Read more
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>
        </a>
      </div>
      <div class="feature col">
        <img
          src="<?php echo wplite_get_webp_url('placeholder', '', [75, 75]) ?>"
          width="75"
          height="75"
          alt="Alt text"
          loading="lazy"
          decoding="async"
          class="feature__icon img-fluid mb-2" />
        <h3 class="feature__heading fw-bold">Lorem ipsum</h3>
        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        <a
          href="https://"
          class="feature__link text-decoration-none fw-bold"
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

<section
  id=""
  class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="mb-5 text-center">
          <h2 class="display-5 fw-bold">FAQs</h2>
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>

        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-header">
              <button
                data-bs-toggle="collapse"
                data-bs-target="#accordion-item-1"
                aria-expanded="false"
                aria-controls="accordion-item-1"
                type="button"
                class="accordion-button collapsed">Lorem ipsum dolor sit amet</button>
            </div>
            <div
              id="accordion-item-1"
              class="accordion-collapse collapse show">
              <div class="accordion-body">
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              <button
                data-bs-toggle="collapse"
                data-bs-target="#accordion-item-2"
                aria-expanded="false"
                aria-controls="accordion-item-2"
                type="button"
                class="accordion-button collapsed">Lorem ipsum dolor sit amet</button>
            </div>
            <div
              id="accordion-item-2"
              class="accordion-collapse collapse">
              <div class="accordion-body">
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              <button
                data-bs-toggle="collapse"
                data-bs-target="#accordion-item-3"
                aria-expanded="false"
                aria-controls="accordion-item-3"
                type="button"
                class="accordion-button collapsed">Lorem ipsum dolor sit amet</button>
            </div>
            <div
              id="accordion-item-3"
              class="accordion-collapse collapse">
              <div class="accordion-body">
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section
  id=""
  class="bg-primary bg-opacity-75 py-5 position-relative">
  <div class="container position-relative z-1">
    <h2 class="text-white display-5 fw-bold text-center">Testimonials</h2>

    <div
      id="testimonial-carousel"
      class="testimonial-carousel carousel slide mt-5"
      data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="testimonial-carousel__item carousel-item active">
          <div class="testimonial-carousel__card">
            <div class="testimonial-carousel__body">
              <img
                src="<?php echo wplite_get_webp_url('avatar', '', [75, 75]) ?>"
                width="75"
                height="75"
                alt="Person's Avatar"
                loading="lazy"
                decoding="async"
                class="testimonial-carousel__avatar img-fluid" />
              <h3 class="testimonial-carousel__title">Person's Name</h3>
              <p class="testimonial-carousel__subtitle">Person's Name</p>
              <p class="testimonial-carousel__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
        <div class="testimonial-carousel__item carousel-item">
          <div class="testimonial-carousel__card">
            <div class="testimonial-carousel__body">
              <img
                src="<?php echo wplite_get_webp_url('avatar', '', [75, 75]) ?>"
                width="75"
                height="75"
                alt="Person's Avatar"
                loading="lazy"
                decoding="async"
                class="testimonial-carousel__avatar img-fluid" />
              <h3 class="testimonial-carousel__title">Person's Name</h3>
              <p class="testimonial-carousel__subtitle">Person's Name</p>
              <p class="testimonial-carousel__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
        <div class="testimonial-carousel__item carousel-item">
          <div class="testimonial-carousel__card">
            <div class="testimonial-carousel__body">
              <img
                src="<?php echo wplite_get_webp_url('avatar', '', [75, 75]) ?>"
                width="75"
                height="75"
                alt="Person's Avatar"
                loading="lazy"
                decoding="async"
                class="testimonial-carousel__avatar img-fluid" />
              <h3 class="testimonial-carousel__title">Person's Name</h3>
              <p class="testimonial-carousel__subtitle">Person's Name</p>
              <p class="testimonial-carousel__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#testimonial-carousel"
        data-bs-slide="prev">
        <span
          class="carousel-control-prev-icon"
          aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#testimonial-carousel"
        data-bs-slide="next">
        <span
          class="carousel-control-next-icon"
          aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

<?php
get_footer();
