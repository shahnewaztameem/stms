<?php

namespace App;

use App\TaskFile;
use Illuminate\Database\Eloquent\Model;

class WireframeFeedback extends Model
{
    protected $guarded = [];

    public function task_file()
    {
        return $this->belongsTo(TaskFile::class, 'id', 'task_files_id');
    }
}
