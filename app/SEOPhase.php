<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SEOPhase extends Model
{
    protected $table = 'seo_phases';
    protected $guarded = [];

    public function seo_pm()
    {
        return $this->belongsTo(User::class, 'seo_pm_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}