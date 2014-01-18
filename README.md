# Templator

A Clean Solution for Templating with [Twig](twig.sensiolabs.org)

[![Build Status](https://travis-ci.org/Kristories/Templator.png)](https://travis-ci.org/Kristories/Templator)

## Installation

Add the following into your `composer.json` file:

    {
        "require": {
            "kristories/templator": "*"
        }
    }

Then run

    composer install


## Usage

### Basic

    $templator = new \Templator\Templator();

    // Set data
    $templator->data('foo', 'bar');

    // Render
    // Let's define a base template /templates/base/base_template.html
    // and a child template         /templates/pages/page.html
    echo $templator->render('base_template', 'page');

### Config

    $templator = new \Templator\Templator([
        'path'  => [
            'root'      => 'templates',
            'base'      => 'base',
            'pages'     => 'pages',
            'widgets'   => 'widgets'
        ],
        'cache' => NULL
    ]);

Structure :

    ├── templates
    |   ├── base
    |   └── pages
    |   └── widgets
    └── cache

### Data

    $templator->data('foo', 'bar');
    // or
    $templator->data([
        'foo' => 'bar',
        'bar' => 'baz'
    ]);

### Widgets

    $templator->widgets([
        'header' => ['logo', 'mainmenu', 'search'],
        'footer' => ['copyright, 'footermenu']
    ]);

### Example

`/index.html`

    $templator = new \Templator\Templator();

    $data = [
        'hello' => 'world'
    ];
    $widgets = [
        'header' => ['logo']
    ];

    // Support method chaining
    $templator->data($data)->widgets($widgets);

    // Output
    echo $templator->render('base_template', 'page');

`/templates/base_template.html`
    
    {% block header %}{% endblock %}
    {% block content %}{% endblock %}

`/templates/pages/page.html`
    
    <h3>Hello {{ hello }}!</h3>

`/templates/widgets/logo.html`

    <h1>LOGO</h1>

## Why Twig?

### Twig is a modern template engine for PHP

- **Fast**: Twig compiles templates down to plain optimized PHP code. The overhead compared to regular PHP code was reduced to the very minimum.
- **Secure**: Twig has a sandbox mode to evaluate untrusted template code. This allows Twig to be used as a template language for applications where users may modify the template design.
- **Flexible**: Twig is powered by a flexible lexer and parser. This allows the developer to define its own custom tags and filters, and create its own DSL.