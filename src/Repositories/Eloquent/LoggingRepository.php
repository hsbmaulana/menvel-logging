<?php

namespace Menvel\Logging\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Menvel\Logging\Models\Logging;
use Menvel\Logging\Events\Loging;
use Menvel\Logging\Events\Loged;
use Menvel\Logging\Events\Unloging;
use Menvel\Logging\Events\Unloged;
use Menvel\Repository\AbstractRepository;
use Menvel\Logging\Contracts\Repository\ILoggingRepository;

class LoggingRepository extends AbstractRepository implements ILoggingRepository
{
    /**
     * @param array $querystring
     * @return mixed
     */
    public function all($querystring = [])
    {
        $user = $this->user; $content = null;
        $querystring =
        [
            'logging_limit' => $querystring['logging_limit'] ?? 10,
            'logging_current_page' => $querystring['logging_current_page'] ?? 1,
        ];
        extract($querystring);

        $user = $user->setRelation('logs', $user->logs()->paginate($logging_limit, '*', 'logging_current_page', $logging_current_page)->appends($querystring));
        $content = $user->loadCount(
        [
            'logDebugs',
            'logInfos',
            'logNotices',
            'logWarnings',
            'logErrors',
            'logCriticals',
            'logAlerts',
            'logEmergencies',
        ]);

        return $content;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add($data)
    {
        $user = $this->user; $content = null;

        DB::beginTransaction();

        try {

            $content = $user->logs()->create([ 'level' => $data['level'], 'message' => $data['message'], 'context' => $data['context'], 'user_ip' => $data['user_ip'], 'user_agent' => $data['user_agent'], ]);

            DB::commit();

            event(new Loged($content));

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logDebug($data)
    {
        $data['level'] = Logging::LEVEL_DEBUG;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logInfo($data)
    {
        $data['level'] = Logging::LEVEL_INFO;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logNotice($data)
    {
        $data['level'] = Logging::LEVEL_NOTICE;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logWarning($data)
    {
        $data['level'] = Logging::LEVEL_WARNING;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logError($data)
    {
        $data['level'] = Logging::LEVEL_ERROR;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logCritical($data)
    {
        $data['level'] = Logging::LEVEL_CRITICAL;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logAlert($data)
    {
        $data['level'] = Logging::LEVEL_ALERT;

        return $this->add($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function logEmergency($data)
    {
        $data['level'] = Logging::LEVEL_EMERGENCY;

        return $this->add($data);
    }

    /**
     * @param int|string $identifier
     * @return mixed
     */
    public function remove($identifier)
    {
        $user = $this->user; $content = null;

        $content = $user->logs()->where('id', $identifier)->firstOrFail();

        DB::beginTransaction();

        try {

            $content->delete();

            DB::commit();

            event(new Unloged($content));

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $uuid
     * @return mixed
     */
    public function unlog($uuid)
    {
        return $this->remove($uuid);
    }
}