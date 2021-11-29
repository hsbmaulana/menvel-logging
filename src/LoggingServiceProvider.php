<?php

namespace Menvel\Logging;

use Menvel\Repository\RepositoryServiceProvider as ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $map =
    [
        \Menvel\Logging\Contracts\Repository\ILoggingRepository::class => \Menvel\Logging\Repositories\Eloquent\LoggingRepository::class,
    ];

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}