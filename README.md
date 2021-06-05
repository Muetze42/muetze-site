# Laravel Package

## Install
``` bash
composer require norman-huth/muetze-site
```
---
## Usage
### Commands
#### Create Pivot Table
This command creates a migration for a many-to-many relationship between 2 models.   
The 2 models of the relationship must be specified in the command.
``` bash
php artisan make:migration:pivot User Role
```

#### Create Model And Nova Ressource
``` bash
php artisan nova:model Foo
```
Create with migration and policy
``` bash
php artisan nova:model Foo --m --p
```
---
### Traits
#### Encrypt Attributes
The attributes always stored encrypted in the database, but output decrypted.  
For these attributes simply create a column text (nullable) and specify in the array encrypts.
``` php
<?php

namespace App\Models;

use NormanHuth\Muetze\Traits\EncryptsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use EncryptsAttributes; // <- Don't forget

    /**
     * The attributes that are encrypted.
     *
     * @var array
     */
    protected array $encrypts = [
        'access_token',
        'address',
    ];
}
```
---
### Publish
#### Improved Laravel Migration Stubs
No more problem with duplicate class names
``` bash
php artisan vendor:publish --provider="NormanHuth\Muetze\SiteServiceProvider" --tag="laravel-stubs"
```

#### A Bit Modern Nova Resource Stub
``` bash
php artisan vendor:publish --provider="NormanHuth\Muetze\SiteServiceProvider" --tag="nova-stubs"
```

#### Additional Language File(s)
For example, to keep the Laravel translations in the original state and in case of an update they can be renewed without merge.
``` bash
php artisan vendor:publish --provider="NormanHuth\Muetze\SiteServiceProvider" --tag="translations"
```

---
### Helper Functions
[Helpers/functions.php](https://github.com/Muetze42/muetze-site/blob/main/Helpers/functions.php)
