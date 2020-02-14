<?php

namespace App;

use App\Task;
use App\WireframeFeedback;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    protected $guarded = [];
    
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function wireframe_feedback()
    {
        return $this->hasMany(WireframeFeedback::class, 'task_files_id', 'id');
    }
}