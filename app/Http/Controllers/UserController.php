<?php

namespace App\Http\Controllers;

use App\DesignPhase;
use App\DevelopmentPhase;
use App\SEOPhase;
use App\Task;

class UserController extends Controller
{
    /**
     * Get all the tasks for the logged in user
     *
     * @return view with the tasks
     */
    public function index()
    {
        $user = auth()->user();
        // return $user;
        $tasks = Task::where('project_manager_id', auth()->user()->id)->with('design_phase', 'development_phase', 'seo_phase')->get();
        $designPhase = DesignPhase::where('design_pm_id', auth()->user()->id)->with('task')->get();
        $devPhase = DevelopmentPhase::where('dev_pm_id', auth()->user()->id)->with('task')->get();
        $seoPhase = SEOPhase::where('seo_pm_id', auth()->user()->id)->with('task')->get();
        // return $tasks;
        return view('user.home', compact('user', 'tasks'));
    }

    /**
     * View a single task
     * It searches with the slug for email HASH url 
     * 
     * @param [type] $slug
     * @return void
     */
    public function view($slug)
    {
        $task = Task::where('slug', $slug)
            ->with(
                'client',
                'project_manager',
                'task_files',
                'task_files.wireframe_feedback',
                'design_phase',
                'design_phase.design_pm',
                'development_phase',
                'development_phase.dev_pm',
                'seo_phase',
                'seo_phase.seo_pm',
                'feedback'
            )->first();
        // return $task;
        return view('user.view_task', compact('task'));
    }

        /**
     * Get All the task-design phase
     *
     * @return projectList
     */
    public function design_phase()
    {
        $designPhase = DesignPhase::where('design_pm_id', auth()->user()->id)->with('task', 'task.task_files')->latest()->paginate(6);
        // return $designPhase;
        return view('user.design_phase', compact('designPhase'));
    }

    /**
     * Get All the task-development phase
     *
     * @return projectList
     */
    public function dev_phase()
    {
        $dev_phase = DevelopmentPhase::where('dev_pm_id', auth()->user()->id)->with('task')->latest()->paginate(6);
        // return $dev_phase;
        return view('user.dev_phase', compact('dev_phase'));
    }

    /**
     * Get All the task-seo phase
     *
     * @return projectList
     */
    public function seo_phase()
    {
        $seoPhase = SEOPhase::where('seo_pm_id', auth()->user()->id)->with('task')->latest()->paginate(6);

        // return $seoPhase;
        return view('user.seo_phase', compact('seoPhase'));
    }
}