<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SEOPhase extends Model
{
    protected $table = 'seo_phases';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'id', 'task_id');
    }
}