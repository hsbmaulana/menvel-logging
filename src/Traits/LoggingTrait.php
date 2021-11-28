<?php

namespace Menvel\Logging\Traits;

use Menvel\Logging\Models\Logging;

trait LoggingTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function logs()
    {
        return $this->hasMany(Logging::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logDebugs()
    {
        return $this->logs()->level(Logging::LEVEL_DEBUG);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logInfos()
    {
        return $this->logs()->level(Logging::LEVEL_INFO);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logNotices()
    {
        return $this->logs()->level(Logging::LEVEL_NOTICE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logWarnings()
    {
        return $this->logs()->level(Logging::LEVEL_WARNING);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logErrors()
    {
        return $this->logs()->level(Logging::LEVEL_ERROR);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logCriticals()
    {
        return $this->logs()->level(Logging::LEVEL_CRITICAL);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logAlerts()
    {
        return $this->logs()->level(Logging::LEVEL_ALERT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function logEmergencies()
    {
        return $this->logs()->level(Logging::LEVEL_EMERGENCY);
    }
}