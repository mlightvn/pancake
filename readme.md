Demo website: [https://rakupons.net/](https://rakupons.net/)

# Table of Contents
1. [My note](#my_note)
2. [Setup](#setup)
3. [User screen](#user_screen)
4. [Homepage](#homepage)
5. [Main menu](#main_menu)
6. [Sliders](#sliders)
7. [Partner slider](#partner_sliders)
8. [Products area](#products_area)
9. [Other pages](#other_pages)
10. [Admin page](#admin_pages)

# Support Me
This eCommerce site was developed during my free time and I will be glad if somebody will support me.

[Donate with paypal](https://www.paypal.me/rakujin)

Any amount would be big help to me.

Thank you so much.

<div id='my_note'/>
# My note
I pushed almost code in Controller class, in order to make new page, just copy for extending and take few hour to finish: List page, insert, update, display on user screen.

Now user layout is not really beautiful, I hope I can make it better or someone can help me.

<div id='setup'/>
# Setup
This project was made from Laravel Framework 5. And was installed some components:
> laravel-debugbar
> socialite
> ckeditor
> html
> image
> ...

Setup virtual host for this code.

```
<VirtualHost *:80>
    DocumentRoot "/var/www/vhosts/pancake/www/httpdocs/public"
    ServerName pancake.com
    ErrorLog "/var/log/pancake.com.error.log"
    CustomLog "/var/log/pancake.com.access.log" combined
    <Directory "/var/www/vhosts/pancake/www/httpdocs">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

And copy this code to folder "pancake".

> "/var/www/vhosts/pancake"

<div id='user_screen'/>
# User screen
<div id='homepage'/>
## Homepage
<div id='main_menu'/>
### Main menu:
Data was retrieved from "categories" table

For example:

> Small size
> Medium size
> Large size
> Others

<div id='sliders'/>
### Sliders
`/www/httpdocs/resources/views/_include/user_slide.blade.php`

Images are saving in "public/image/promotion/" folder.

This script of slider I copied from the Internet.

<div id='partner_sliders'/>
### Partner slider
Same as above

<div id='products_area'/>
### Products area
They are showing 8 products from each Category.

<div id='other_pages'/>
## Other pages
* Search/list page
* Product detail
* Partner/shops pages
* Contact
* ...

<div id='admin_pages'/>
# Admin page
* Categories
* Shops
* Products
* Users
