<h1 align="center">Menvel-Logging</h1>

Menvel-Logging is a logging helper for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require hsbmaulana/menvel-logging
```

How to use it :

- Put `Menvel\Logging\LoggingServiceProvider` to service provider configuration list.

- Migrate.

```
$ php artisan migrate
```

- Sample usage.

```php
use Menvel\Logging\Contracts\Repository\ILoggingRepository;

$repository = app(ILoggingRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->logDebug([ 'message' => "...", 'context' => [ "...", ], 'user_ip' => "127.0.0.1", 'user_agent' => "Symfony", ]); //
// $repository->unlog('...'); //
// $repository->all(); //
```

Author
---

- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
