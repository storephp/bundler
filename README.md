# StorePHP Bundler

This is StorePHP's framework for building bundles

## Module structure

```text
.
└── <vendor>/<module>/
    └── etc/
    │   ├── forms
    │   ├── grids
    │   ├── routes/
    │   │   └── admin.php
    │   ├── module.php
    │   └── sidebar.php
    └── storephp.php
```

## create new module

Create a `storephp.php` file in `module` directory in the `vendor` directory

```php title=storephp.php
<?php

use StorePHP\Bundler\BundleRegistrar;

BundleRegistrar::register(BundleRegistrar::MODULE, '<vendor>_<module>', __DIR__);
```
