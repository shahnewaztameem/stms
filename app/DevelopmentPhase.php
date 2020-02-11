<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DevelopmentPhase extends Model
{
    protected $guarded = [];

    public function dev_pm()
    {
        return $this->belongsTo(User::class, 'dev_pm_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}