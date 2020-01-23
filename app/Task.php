<?php

namespace App;

use App\User;
use App\TaskFile;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function task_files()
    {
        return $this->hasMany(TaskFile::class, 'task_id');
    }
}