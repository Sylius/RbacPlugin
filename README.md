<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Rbac Plugin</h1>

<p align="center">This plugin provides basic roles and permissions management functionality for Sylius application.</p>

#### Beware!

Adding Write access to a permission automatically means adding Read access.

Write permission access means also updating and deleting.

## Installation

1. Require plugin with composer:

    ```bash
    composer require sylius/rbac-plugin
    ```

2. Add plugin class and other required bundles to your `AppKernel`.

    ```php
    $bundles = [
       new \Sylius\RbacPlugin\SyliusRbacPlugin(),
    ];
    ```

3. Make sure to have ProophServiceBusBundle in your `AppKernel` as well:

    ```php
    $bundles = [
        new \Prooph\Bundle\ServiceBus\ProophServiceBusBundle(),
    ];
    ```

4. Import routing:

    ```yaml
    sylius_rbac:
        resource: "@SyliusRbacPlugin/Resources/config/routing.yml"
    ```

5. Import configuration:

    ```yaml
    - { resource: "@SyliusRbacPlugin/Resources/config/config.yml" }
    ```

6. Copy plugin migrations to your migrations directory (e.g. `src/Migrations`) and apply them to your database:

    ```bash
    cp -R vendor/sylius/rbac-plugin/migrations/* "<path/to/your/migrations>"
    bin/console doctrine:migrations:migrate
    ```

7. Copy templates from `vendor/sylius/rbac-plugin/src/Resources/views/SyliusAdminBundle/`
to `app/Resources/SyliusAdminBundle/views/`

8. Run installation command

    ```bash
    bin/console sylius-rbac:install-plugin
    ```
    
    Where sylius-rbac:install-plugin consists of:
    
    1)
    ```bash
    bin/console sylius-rbac:grant-access <roleName> <adminSections>
    ```

    Where `adminSections` can be a space-separated list of any of these:
    * catalogManagement
    * configuration
    * customerManagement
    * marketingManagement
    * salesManagement

    Administrator's email is provided by plugin user via CLI.

    e.g. `bin/console sylius-rbac:grant-access administrator configuration catalogManagement`

    `In order to permit access to admin panel sections, please provide administrator's email address: sylius@example.com`


## Sections configuration

By default, **RbacPlugin** is provided with access configuration for basic Sylius sections (catalog, configuration, customers, marketing and sales) as well as for RBAC section, added by the plugin itself.
Each section has a bunch of route prefixes associated with them, that describes which section gives permissions to which resources management.

However, usually, a Sylius application has a plenty of custom functions within existing or entirely new sections. This plugin allows you to extend its configuration, in order to restrict access to these custom routes.

For the matter of example let's assume we have a simple `Supplier` resource (containing only `string $name` property). It also has already generated routes, that we would like to restrict access to:

- `app_admin_supplier_index`
- `app_admin_supplier_create`
- `app_admin_supplier_update`
- `app_admin_supplier_bulk_delete`
- `app_admin_supplier_delete`

If you don't know how to create and configure custom resource in Sylius application, check out [relevant documentation chapter](https://docs.sylius.com/en/1.3/cookbook/entities/custom-model.html).

### Extending basic Sylius section with new route prefixes

The only thing required to restrict Supplier-related routes with, for example, "Customer management" permission, is adding appropriate route prefix to customers section configuration:

```yaml
sylius_rbac:
    sylius_sections:
        customers:
            - app_admin_supplier
```

You would probably also want to add extend "Customers" section in Admin main menu (take a look at [this docs chapter](https://docs.sylius.com/en/1.3/customization/menu.html) for more information).

![Customers sections customized](docs/customers_section_customized.png)

As a result, each Administrator allowed to manage customers in the Admin panel would also be able to manage Suppliers. You may also notice, nothing has changed in permissions configuration form,
as no new section has been added to the RBAC configuration.

![Permissions configuration - no changes](docs/permissions_configuration_no_changes.png)

### Adding a custom section to the application

What if you want to differentiate your new resources management permission? The other possibility is to define your own, custom section in a plugin configuration:

```yaml
sylius_rbac:
    custom_sections:
        suppliers:
            - app_admin_supplier
```

> Curiosity: RBAC is also defined as a custom section! You can easily check it out in a plugin source code.

With such a configuration, you should notice a new permission configuration available in the Administration Role form.

![Permissions configuration - no changes](docs/permissions_configuration_changes.png)

To display new permission name nicely, you should also configure a translation in your application's translation file:

```yaml
sylius_rbac:
    ui:
        permission:
            suppliers: Suppliers
```

#### Remember!

When configuring a custom section in Admin main menu, name it the same way you named it under `custom_sections` key in the plugin configuration. It will be automatically hidden and shown, exactly as 
basic Sylius sections!

```php
$suppliersSubmenu = $menu->addChild('suppliers')->setLabel('Suppliers');

$suppliersSubmenu
    ->addChild('supplier', ['route' => 'app_admin_supplier_index'])
    ->setLabel('Manage Suppliers')
    ->setLabelAttribute('icon', 'address card outline')
;
``` 

![Suppliers section](docs/suppliers_section.png)

After these few simple steps, you can already give your custom permission to any already existent Administration role.

## Security issues

If you think that you have found a security issue, please do not use the issue tracker and do not post it publicly.
Instead, all security issues must be sent to `security@sylius.com`.
