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

#### make:bundle Command
Create a model with a migration and policy  
(The default can be adjusted in config.)
``` bash
php artisan make:bundle Foo
```
Create with options to create resources disabled by config anyway.
``` bash
// {--n : create with nova ressource}
// {--m : create with migration}
// {--p : create with policy}
// {--r : create with resource}
php artisan make:bundle Foo --n --m --p --r
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
### Blade Components
#### Markdown
Parse markdown
``` html
<x-site-markdown>
    {{ $markdown }}
</x-site-markdown>
```
Parse markdown without stripping whitespace (or other characters) from the beginning in each line of a string
``` html
<x-site-markdown :trim="false">
    {{ $markdown }}
</x-site-markdown>
```
Parse Markdown file
``` html
<x-site-markdown :file="$markdown" />

<!-- Don't forget the single quotes (:file) -->
<x-site-markdown :trim="false" :file="'/path/to/file.md'" />

<x-site-markdown :file="resource_path('views/markdowns/content.md')" :trim="false" />
```
---
### Publish
#### Config file
Change the default details of the make:bundle command
``` bash
php artisan vendor:publish --provider="NormanHuth\Muetze\SiteServiceProvider" --tag="config"
```
Default:
``` php
    'make-bundle' => [
        'nova-ressource' => false,
        'migration'      => true,
        'policy'         => true,
        'resource'       => false,
    ],
```
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
