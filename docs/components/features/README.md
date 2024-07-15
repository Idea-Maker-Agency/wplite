# Features

A reusable HTML features grid to standardize rendering, improve maintainability, and ensure consistent styling and functionality across the project.

## Usage

Use the `wplite:features` VSCode snippet to quickly insert features grid HTML markup.

## Example

```phtml
<div class="row row-cols-1 row-cols-lg-3 g-4">
  <div class="feature col">
    <img
      src="<?php echo wplite_get_webp_url( 'placeholder', '', [ 75, 75 ] ) ?>"
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
      src="<?php echo wplite_get_webp_url( 'placeholder', '', [ 75, 75 ] ) ?>"
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
      src="<?php echo wplite_get_webp_url( 'placeholder', '', [ 75, 75 ] ) ?>"
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
```

## Useful Links:

- [Bootstrap](https://getbootstrap.com/) > [Grid](https://getbootstrap.com/docs/5.3/layout/grid/)
