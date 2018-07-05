<?php


namespace App\Observers;


use App\Models\Traits\Auditable;
use App\Jobs\AuditJob;
use Auth;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    public $excluded = ['created_at', 'updated_at'];

    protected $user;

    public function __construct($user = null)
    {
        $this->user = is_null($user) ? Auth::guard('employers')->user() : $user;
    }

    /**
     * @param Model|Auditable $model
     */
    public function created($model)
    {
        $this->createJob($model, 'created');
    }

    /**
     * @param Model|Auditable $model
     */
    public function updated($model)
    {
        $this->createJob($model, 'updated');
    }

    /**
     * @param Model|Auditable $model
     */
    public function deleted($model)
    {
        $this->createJob($model, 'deleted');
    }

    /**
     * @param Model|Auditable $model
     * @param $event
     */
    protected function createJob($model, $event)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userType = get_class($user);
            $userId = $user->id;
        } else {
            $userType = null;
            $userId = null;
        }

        $modelType = get_class($model);
        $modelId = $model->id;


        $ip = \Request::ip();

        $excluded = array_merge($this->excluded, $model->getAuditExcludes());
        $original = $model->getOriginal();

        $changes = [];
        foreach (array_except($model->getDirty(), $excluded) as $key => $value) {

            $changes[$key] = [$original[$key] ?? null, $value];
        }

        dispatch(new AuditJob($event, $modelType, $modelId, $userType, $userId, $changes, $ip));
    }
}