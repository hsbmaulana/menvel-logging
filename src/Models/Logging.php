<?php

namespace Menvel\Logging\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Logging extends Model
{
    use SoftDeletes;

    public const LEVEL_DEBUG = 'debug';
    public const LEVEL_INFO = 'info';
    public const LEVEL_NOTICE = 'notice';
    public const LEVEL_WARNING = 'warning';
    public const LEVEL_ERROR = 'error';
    public const LEVEL_CRITICAL = 'critical';
    public const LEVEL_ALERT = 'alert';
    public const LEVEL_EMERGENCY = 'emergency';

    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $fillable = [ 'level', 'message', 'context', 'user_ip', 'user_agent', ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('default', function (\Illuminate\Database\Eloquent\Builder $builder) {

            $builder->latest();
        });

        static::creating(function ($data) {

            $data->id = (string) Str::orderedUuid();
        });
    }

    /**
     * @return array
     */
    public function getContextAttribute()
    {
        return unserialize($this->attributes['context']);
    }

    /**
     * @param string $value
     * @return void
     */
    public function setContextAttribute($value)
    {
        $this->attributes['context'] = serialize($value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $level
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}