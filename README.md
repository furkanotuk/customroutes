# CustomRoutes Class

CustomRoutes is a simple PHP class that provides page routing and session control in a PHP-based web application.

## How to Use

### Installation

To use the CustomRoutes class in your project, follow these steps:

1. Add the `CustomRoutes.php` file to your project.

2. Don't forget to start the session in your project using the `session_start()` function.

3. Use the CustomRoutes class to define your page routes in your project.

```php
<?php

// Include the CustomRoutes class
require_once 'CustomRoutes.php';

// Create an instance of the class
$customRoutes = new CustomRoutes();

// Set the default directory
$customRoutes->setDefault('homepage');

// Define an example route
$customRoutes->route('dashboard', 'dashboard_view', 'dashboard_function', true);

// Call the navigate function
$customRoutes->navigate();
