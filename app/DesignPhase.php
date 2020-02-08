<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DesignPhase extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'id', 'task_id');
    }
}
