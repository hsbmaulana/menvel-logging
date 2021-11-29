<h1 align="center">Menvel-Logging</h1>

Menvel-Logging is a logging helper for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require hsbmaulana/menvel-logging
```

How to use it :

- Publish files.

```
$ php artisan vendor:publish --provider="Menvel\Logging\LoggingServiceProvider"
```

```
$ php artisan migrate
```

- Put `Menvel\Logging\LoggingServiceProvider` to service provider configuration list.

Author
---

- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
