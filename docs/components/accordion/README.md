# Accordion

A reusable HTML accordion component to standardize container rendering, improve maintainability, and ensure consistent styling and functionality across the project.

## Usage

Use the `wplite:accordion` VSCode snippet to quickly insert accordion HTML markup.

## Example

```phtml
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
```

## Useful Links:

- [Bootstrap](https://getbootstrap.com/) > [Accordion](https://getbootstrap.com/docs/5.3/components/accordion/)
