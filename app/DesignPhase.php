<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DesignPhase extends Model
{
    protected $guarded = [];

    public function design_pm()
    {
        return $this->belongsTo(User::class, 'design_pm_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
