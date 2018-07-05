<?php

namespace App\Policies;

use App\Models\Employer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class SuperUserPolicy
{
    use HandlesAuthorization;
    /**
     * @param Employer|User $user
     * @param Model $model
     * @return bool
     */
    public function create($user, $model)
    {
        return $this->check($user, $model);
    }

    public function update($user, $model)
    {
        return $this->check($user, $model);
    }

    public function delete($user, $model)
    {
        return $this->check($user, $model);
    }

    protected function check($user, $model)
    {
        return $user instanceof Employer && $user->is_superuser;
    }
}
