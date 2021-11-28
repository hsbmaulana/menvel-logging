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

        if ($this->app->runningInConsole()) {

            $this->publishes([ __DIR__ . '/../database/migrations' => database_path('migrations'), ], 'menvel-logging-migrations');
        }
    }
}