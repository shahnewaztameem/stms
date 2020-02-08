<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DevelopmentPhase extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'id', 'task_id');
    }
}
