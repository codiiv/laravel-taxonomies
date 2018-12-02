# Laravel Forum Package - Chatter

### Installation

<strong>Background</strong>: This package arises from the necessity to create taxonomies in various projects I create for my clients. It can be used in any other project. It comes with minimal CSS so that it can be adjustable as needed

1. Include the package in your project

    ```
    composer require "codiiv/laravel-taxonomies"
    
    ```

2. Add the service provider to your `config/app.php` providers array:

   **If you're installing on Laravel 5.5+ skip this step**

    ```
    Codiiv\Taxonomies\TaxonomiesServiceProvider::class,
    ```

3. Publish the Vendor Assets files by running:

    ```
    php artisan vendor:publish --provider="Codiiv\Taxonomies\TaxonomiesServiceProvider"

    ```

    This will create a taxonomies folder in the public assets. It will also create a configuration file in the <strong>config/taxonomies.php</strong>

    To set up the taxonomies path, edit the file accordingly.


4. Now that we have published a few new files to our application we need to reload them with the following command:

    ```
    composer dump-autoload
    ```

5. Run Your migrations:

    ```
    php artisan migrate

    ```

    Quick tip: Make sure that you've created a database and added your database credentials in your `.env` file.

6. Lastly, CONFIGURE SUPER ADMIN account.

    Run this command `php artisan taxonomies:superadmin someemail@somedomain.tld `  <strong>replacing someemail@somedomain.tld </strong> by the email of the user you want to set  as super admin. Note that you can only have one super admin.

7. CONFIGURE TAXONOMY Paths

  After running the ``` vendor:publish --force ``` command

Now, visit your ``` site.com/chatteradmin ``` and you should see your new forum admin once logged in!

### Upgrading

Coming soon

### Screenshots

![](https://raw.githubusercontent.com/codiiv/laravel-taxonomies/master/screenshot1.png)
![](https://raw.githubusercontent.com/codiiv/laravel-taxonomies/master/screenshot2.png)
