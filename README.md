# WPLite<!-- omit from toc -->

This guide will help you set up and run a local installation of Wordpress using the WPLite theme.

## Table of Contents

- [Table of Contents](#table-of-contents)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Folder Structure](#folder-structure)
  - [Key Files and Directories](#key-files-and-directories)
- [Components](#components)
- [Style Guide](#style-guide)
  - [HTML elements](#html-elements)
  - [PHP functions](#php-functions)
- [Conclusion](#conclusion)

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- [Docker](https://www.docker.com/) (version 4+ or later)

**[⬆ back to top](#table-of-contents)**

## Installation

Download and install Docker Desktop from [Docker's official website](https://www.docker.com/) based on your operating system (Windows, macOS, or Linux). Then run it after the installation.

Copy the `.env-template` file to `.env` and modify it as needed:

```bash
cp .env-template .env
```

Run the development server:

```bash
docker-compose up
```

**[⬆ back to top](#table-of-contents)**

## Folder Structure

```
project
├── theme
|   ├── assets
|   ├── components
|   ├── lib
|   ├── templates
|   ├── 404.php
|   ├── archive.php
|   ├── category.php
|   ├── comments.php
|   ├── footer.php
|   ├── functions.php
|   ├── header.php
|   ├── home.php
|   ├── index.php
|   ├── page.php
|   ├── screenshot.png
|   ├── search.php
|   ├── single.php
|   ├── style.css
|   └── tag.php
├── .editorconfig
├── .env.template
├── docker-compose.yml
├── package-lock.json
└── package.json
```

### Key Files and Directories

- `theme/`: Contains the main source code for the application.
  - `assets/`: Contains static assets like css, js, images and fonts.
  - `components/`: Contains custom php components.
  - `lib/`: Contains php classes, functions, structure related templates and custom widgets.
  - `404.php`: The template for displaying 404 page.
  - `archive.php`: The template for displaying archive pages.
  - `category.php`: The template for displaying category pages.
  - `comments.php`: The template for displaying comments.
  - `footer.php`: The template for displaying the footer.
  - `front-page.php`: The template for displaying front-page.
  - `functions.php`: The main functions php file.
  - `header.php`: The template for displaying the header.
  - `home.php`: The template for display blog posts page.
  - `index.php`: The main template page.
  - `page.php`: The template for displaying all pages.
  - `screenshot.png`: The template for displaying the header.
  - `search.php`: The template for displaying the header.
  - `single.php`: The template for displaying all single posts.
  - `style.css`: The main stylesheet css file.
  - `tag.php`: The template for displaying tag pages.
- `.editorconfig`: Defines coding styles and indentation settings for consistent formatting across different editors and IDEs.
- `.env-template`: The .env template file.
- `docker-compose.yml`: The docker-compose.yml file configures and manages all application services, allowing you to build and run your multi-container Docker application with a single command.
- `package.json`: The project's manifest file, listing metadata, dependencies, and scripts.

**[⬆ back to top](#table-of-contents)**

## Components

The project includes custom VSCode code snippets, based on Bootstrap 5.3.3, to enhance your development workflow by providing quick access to commonly used code patterns and templates, improving productivity and efficiency. Here are the following reusable vscode snippets:

- [`wplite:accordion`](/docs/components/accordion/README.md)
- [`wplite:button`](/docs/components/button/README.md)
- [`wplite:card`](/docs/components/card/README.md)
- [`wplite:container`](/docs/components/container/README.md)
- `wplite:features`
- `wplite:hero-banner`
- [`wplite:image`](/docs/components/image/README.md)
- [`wplite:link`](/docs/components/link/README.md)
- `wplite:media-block`
- `wplite:page-content`
- [`wplite:unordered-list`](/docs/components/unordered-list/README.md)

**[⬆ back to top](#table-of-contents)**

## Style Guide

A well-defined style guide is essential for maintaining consistency, readability, and quality across your project's codebase. Here are some of our recommended style guide for the scaffold:

#### HTML elements

If an HTML element has multiple attributes, put every attributes into new line.

> Why? It enables you to read and organize attributes better.

```phtml
<a
  class="btn btn-light"
  role="button"
  title="Get Started">
  Get Started
</a>
```

#### PHP functions

Prefix php functions, hooks or filters.

> Why? Prefixing PHP functions helps avoid naming conflicts, improves code organization, and makes it easier to identify which functions belong to your custom code or specific libraries.

```php
add_action( 'some_hook', 'wplite_some_hook' );
function wplite_some_hook() {
}
```

Identify the types for function parameters and return values. Also add header comment to the functions to indicate its purpose.

> Why? Identifying PHP function parameter and return types enhances code readability, reduces bugs, and enables better code completion and static analysis by clearly specifying the expected data types for function inputs and outputs.

```php
/**
 * Displays the name and age of a person.
 *
 * @since 1.0.0
 *
 * @param string    $name       The person's name.
 * @param int       $age        The person's age.
 *
 * @return string
 */
function wplite_some_function( string $name, int $age ): string {
  return $name .' is '. $age .'yrs old.';
}
```

**[⬆ back to top](#table-of-contents)**

## Conclusion

You have now set up the WP scaffold and are ready to start building your wordpress website. For more information, detailed guides or wordpress coding reference, refer to the [official Wordpress codex](https://codex.wordpress.org/).

**[⬆ back to top](#table-of-contents)**
