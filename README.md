# CodeigniterMigration To Laravel

CodeigniterMigration is a package to integrate an already started Codeigniter-Session in Laravel 5.


## Requirements

- Laravel >= 5
- PHP >=5.3
- Codeigniter 2.x (not tested with 3.x)


The package includes ServiceProvider and Facade for easy **Laravel** integration.
This is particularly useful if you want to slowly migrate legacy code to laravel and Codeigniter is still responsible for the Login & Authentication.
You can read out the Userdata-Values of the current Codeigniter-session (via cookie-handling). 


## Installation

Require this package with composer:

```
composer require ci2lara/codeigniter_migration
```


After updating composer (composer update), add the ServiceProvider to the providers array in config/app.php




### Add the ServiceProvider

Add the ServiceProvider to config/app.php (Provider-Array)

```
'Ci2Lara\Codeigniter_Migration\Providers\CodeigniterServiceProvider',
```


Also add this to your facades in config/app.php (Class-Aliases-Array):

```
'CodeigniterSession' => 'Ci2Lara\Codeigniter_Migration\Facades\CodeigniterSession',  
```


### CI-Configuration

Copy the package config to your local config with the publish command:

```
php artisan vendor:publish
```


To change the configuration, uncomment the values (e.g. sess_table_name or sess_cookie_name) in the new config/ci_session.php



### Set up the Middleware to read the session

You should only use unencrypted cookies in codeigniter - so Laravel can directly access to the cookie.
Because of security-reasons you have to allow Laravel to use this unencrypted Cookie. 

Change the following Line in your app/Http/Kernel.php in the "$middleware"-Array

```
'Illuminate\Cookie\Middleware\EncryptCookies'
```
to
```
'Ci2Lara\Codeigniter_Migration\Middleware\EncryptCookies'
```

The Package-Middleware only disable the Cookie-Encryption for the configured Cookie-Name only (Default: ci_session, see config/ci_session.php)



## Access to the Codeigniter Session in Laravel 5

Shortly: CodeigniterSession::getUserData()

e.g.
```
\View::share('userdata', CodeigniterSession::getUserData());
```


## Access to some Project-Config-Variables or CI-Config-Variables

You can expand your CI-Code

e.g. in your CodeIgniter-Login-Handling
```
$userdata['ci_config'] = array('version' => '1.0', 'module_xy_enabled' => $this->config->item('modul_xy_enabled'), 'yourconfig' => 'some value');
$CI->session->set_userdata($userdata);
```

In Laravel you can simply access with the following code:
```
CodeigniterSession::getConfigData()->version
```

Try it out
```
dd(CodeigniterSession::getConfigData());
```



## Contributing

Contributions to the CodeigniterMigration are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.


## License

CodeigniterMigration is licensed under the [MIT License](http://opensource.org/licenses/MIT).

Copyright 2015 [Andreas Schwinger]
