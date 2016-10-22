CKEditor Package
=====================

## Installation
### Set up package

```
composer require rofilde/laravel-ckeditor
php artisan vendor:publish --tag=ckeditor
```

### Add ServiceProvider

Edit config/app.php, add the following file to `Application Service Providers` section.
```
Rofilde\Ckeditor\ServiceProvider::class,
```

## Usage

Default way (initiate by name or id) :

```javascript
    <script src="/rofil-ckeditor/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
```

Or if you want to initiate by jQuery selector :

```javascript
    <script src="/rofil-ckeditor/laravel-ckeditor/ckeditor.js"></script>
    <script src="/rofil-ckeditor/laravel-ckeditor/adapters/jquery.js"></script>
    <script>
        $('textarea').ckeditor();
        // $('.textarea').ckeditor(); // if class is prefered.
    </script>
```

## File Uplader Integration

 Instead of using KCFinder, we recommend [laravel-filemanager](https://github.com/UniSharp/laravel-filemanager) for the file uploader integration for better laravel user access control and specific per user folders.
