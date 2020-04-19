## About Shopping Mart

Shopping Mart allows Admin to add, edit, remove or disable/hide products. These products are visible to the Customers in form of cards in a paginated mannar.

It is required to link storage to public folder, that can be done using
```
    php artisan storage:link
```
Default File system has to be set to public.
In .env file place,
```
    FILESYSTEM_DRIVER=public
```
Admin Login: /admin

Admin Registration: /admin/register
