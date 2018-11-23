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

2. Add plugin class and other required bundles to your `AppKernel`:

    ```php
    $bundles = [
       new \Sylius\RbacPlugin\SyliusRbacPlugin(),
    ];
    ```
2.1 Make sure to have Proohp

3. Import routing:

    ```yaml
    sylius_rbac:
        resource: "@SyliusRbacPlugin/Resources/config/routing.yml"
    ```

4. Import configuration:

    ```yaml
    - { resource: "@SyliusRbacPlugin/Resources/config/config.yml" }
    ```

5. Copy plugin migrations to your migrations directory (e.g. `src/Migrations`) and apply them to your database:

    ```bash
    cp -R vendor/sylius/rbac-plugin/migrations/* <path/to/your/migrations>
    bin/console doctrine:migrations:migrate
    ```
    
5.1 Add your local admin user to permissoins
    
    ```bash
    bin/console sylius-rbac:grant-configuration-access <email> configuration
    ```
    
6. Copy templates from `vendor/sylius/rbac-plugin/src/Resources/views/SyliusAdminBundle/`
to `app/Resources/SyliusAdminBundle/views/`

## Security issues

If you think that you have found a security issue, please do not use the issue tracker and do not post it publicly. 
Instead, all security issues must be sent to `security@sylius.com`.
