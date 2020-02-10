<?php

namespace App;

use App\Task;
use App\DesignPhase;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'company', 'email', 'password', 'user_type', 'phone_number', 'other_info'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client_tasks()
    {
        return $this->hasMany(Task::class, 'client_id', 'id');
    }

    public function pm_tasks()
    {
        return $this->hasMany(Task::class, 'project_manager_id', 'id');
    }

    public function design_phase()
    {
        return $this->hasMany(DesignPhase::class, 'design_pm_id', 'id');
    }
}