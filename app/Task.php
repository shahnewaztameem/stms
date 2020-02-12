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
    /**
     * Relation with project manager
     *
     * @return void
     */
    public function project_manager()
    {
        return $this->belongsTo(User::class, 'project_manager_id', 'id');
    }

    /**
     * Relation with client
     *
     * @return void
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    /**
     * Relation with files
     *
     * @return void
     */
    public function task_files()
    {
        return $this->hasMany(TaskFile::class, 'task_id');
    }

    /**
     * Relation with design-phase
     *
     * @return void
     */
    public function design_phase()
    {
        return $this->hasOne(DesignPhase::class, 'task_id', 'id');
    }

    /**
     * Relation with development-phase
     *
     * @return void
     */
    public function development_phase()
    {
        return $this->hasOne(DevelopmentPhase::class, 'task_id', 'id');
    }

    /**
     * Relation with seo-phase
     *
     * @return void
     */
    public function seo_phase()
    {
        return $this->hasOne(SEOPhase::class, 'task_id', 'id');
    }

    /**
     * Relation with feedback
     *
     * @return void
     */
    public function feedback()
    {
        return $this->hasOne(ClientFeedback::class, 'task_id');
    }
}