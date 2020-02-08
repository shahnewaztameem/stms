<?php

namespace App;

use App\User;
use App\SEOPhase;
use App\TaskFile;
use App\DesignPhase;
use App\ClientFeedback;
use App\DevelopmentPhase;
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


    public function design_phase()
    {
        return $this->hasOne(DesignPhase::class, 'task_id', 'id');
    }

    public function development_phase()
    {
        return $this->hasOne(DevelopmentPhase::class, 'task_id', 'id');
    }

    public function seo_phase()
    {
        return $this->hasOne(SEOPhase::class, 'task_id', 'id');
    }

    public function feedback()
    {
        return $this->hasOne(ClientFeedback::class, 'task_id');
    }
}