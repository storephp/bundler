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
    │   ├── acl.php
    │   ├── module.php
    │   └── sidebar.php
    └── storephp.php
```

## create new module

Create a `storephp.php` file in the `module` directory in the `vendor` directory

```php title=storephp.php
<?php

use StorePHP\Bundler\BundleRegistrar;

BundleRegistrar::register(BundleRegistrar::MODULE, '<vendor>_<module>', __DIR__);
```

## Forms

### build new form

```php
<?php

use StorePHP\Bundler\Lib\Form\Fields;
use StorePHP\Bundler\Lib\Form\Tabs;

return new class
{
    public function tabs(Tabs $tabs)
    {
        $tabs->addTab('default', 'Product info');
        $tabs->addTab('priceing', 'Product price');
        $tabs->addTab('images', 'Images');
    }

    public function fields(Fields $form)
    {
        $form->addField('text', [
            'label' => 'Product name',
            'model' => 'name',
            'rules' => 'required',
            'order' => 10,
        ]);

        $form->addField('text', [
            'label' => 'Product price',
            'model' => 'price',
            'rules' => 'required',
            'order' => 10,
            'hint' => 'Add product price',
        ], 'priceing');

        $form->addField('text', [
            'label' => 'Product discount price',
            'model' => 'discount_price',
            'rules' => 'nullable',
            'order' => 20,
            'hint' => 'Add product discount price',
        ], 'priceing');

        $form->addField('file', [
            'label' => 'Product thumbnail',
            'model' => 'thumbnail_path',
            'rules' => 'required',
            'order' => 10,
            'hint' => 'Update product',
        ], 'images');
    }
};
```

### Runder this form

```php
<?php

namespace StorePHP\Catalog\Http\Livewire\Products;

use Livewire\WithFileUploads;
use Store\Support\Facades\Product;
use StorePHP\Bundler\Abstracts\FromAbstract;
use StorePHP\Dashboard\Views\Layouts\DashboardLayout;

class ProductCreate extends FromAbstract
{
    use WithFileUploads;

    protected $pretitle = 'Catalog';
    protected $title = 'Create new product';

    public $formId = 'storephp_catalog_products_form';

    public function layout()
    {
        return DashboardLayout::class;
    }

    public function submit()
    {
        $validateData = $this->validate();

        $product = Product::create([
            'sku' => $validateData['sku'],
        ]);

        foreach ($this->models(['sku', 'thumbnail_path']) as $model) {
            $product->{$model} = $validateData[$model];
        }

        if ($this->thumbnail_path) {
            $product->thumbnail_path = $this->thumbnail_path->store('photos');
        }

        $product->save();

        return $this->pushAlert('success', 'The product has been created');
    }
}
```

## Grids

### build new grid

```php
<?php

use StorePHP\Bundler\Lib\Grid\{
    CTA,
    Table,
    Bottom
};

return new class
{
    public function model()
    {
        return config('store.catalog.products.model');
    }

    public function createBottom(Bottom $bottom)
    {
        $bottom->setBottom('Create new product', 'store.dashboard.catalog.products.create');
    }

    public function table(Table $table)
    {
        $table->setColumn('#', 'id')
            ->setColumn('Name', 'name')
            ->setColumn('Slug', 'slug');
    }

    public function CTA(CTA $CTA)
    {
        $CTA->setCall('Edit', [
            'type' => 'route',
            'color' => 'info',
            'route' => 'store.dashboard.catalog.products.update',
        ]);
    }
};
```

### Runder this grid

```php
<?php

namespace StorePHP\Catalog\Http\Livewire\Products;

use StorePHP\Bundler\Abstracts\GridAbstract;
use StorePHP\Dashboard\Views\Layouts\DashboardLayout;

class ProductsIndex extends GridAbstract
{
    public $gridId = 'storephp_catalog_products_index';

    protected $pretitle = 'Catalog';
    protected $title = 'Products listing';

    public function layout()
    {
        return DashboardLayout::class;
    }
}
```

## Create routes

In the routes folder, you can create an admin.php file.

```php
Route::prefix('catalog')->group(function () {
    // Set routes
});
```

## Create ACL

```php title=etc/acl.php
<?php

use StorePHP\Bundler\Lib\ACL;

return new class
{
    public function permissions(ACL $acl)
    {
        $acl->permission('Catalog', 'catalog');
    }
};
```

## module

```php title=etc/module.php
<?php

use StorePHP\Catalog\Providers\StoreCatalogServiceProvider;
use StorePHP\Bundler\Lib\Module;

return new class
{
    public function info(Module $module)
    {
        $module->name('Catalog');
        $module->provoiders([
            StoreCatalogServiceProvider::class
        ]);
    }
};
```

## Sidebar builder

```php title=etc/sidebar.php
<?php

use StorePHP\Bundler\Lib\Sidebar\Menu;
use StorePHP\Bundler\Lib\Sidebar\Links;

return new class
{
    public function menu(Menu $menu)
    {
        $menu->info(
            icon: 'clipboard-list',
            label: 'Catalog',
            order: 20,
        );
    }

    public function links(Links $links)
    {
        $links->link(
            icon: 'category',
            label: 'Categories',
            href: 'store.dashboard.catalog.categories.index',
        );
        $links->link(
            icon: 'packages',
            label: 'Products',
            href: 'store.dashboard.catalog.products.index',
        );
    }
};

```
