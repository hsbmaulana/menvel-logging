<?php

use Menvel\Logging\Models\Logging;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateLoggingsTable extends Migration
{
    /**
     * @var string
     */
    protected $provider;

    /**
     * @var string
     */
    protected $key;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->provider = Auth::guard()->getProvider()->createModel()->getTable();
        $this->key = Str::of($this->provider)->singular() . '_' . 'id';
    }

    /**
     * @return void
     */
    public function up()
    {
        $provider = $this->provider;
        $key = $this->key;

        Schema::create('loggings', function (Blueprint $table) use ($provider, $key) {

            $table->uuid('id');

            $table->text('context');
            $table->string('message');
            $table->enum('level', [ Logging::LEVEL_DEBUG, Logging::LEVEL_INFO, Logging::LEVEL_NOTICE, Logging::LEVEL_WARNING, Logging::LEVEL_ERROR, Logging::LEVEL_CRITICAL, Logging::LEVEL_ALERT, Logging::LEVEL_EMERGENCY, ]);
            $table->string('user_agent');
            $table->ipAddress('user_ip');
            $table->unsignedBigInteger($key);

            $table->timestamp('created_at')->nullable(true);
            $table->timestamp('deleted_at')->nullable(true);

            $table->primary('id');
            $table->foreign($key)->references('id')->on($provider)->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('loggings');
    }
}