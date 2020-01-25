<?php

namespace App;

use App\Task;
use Illuminate\Database\Eloquent\Model;

class ClientFeedback extends Model
{
    protected $guarded = [];
    
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
