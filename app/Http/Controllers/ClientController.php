<?php

namespace App\Http\Controllers;

use App\ClientFeedback;
use App\DesignPhase;
use App\DevelopmentPhase;
use App\Notifications\FeedbackNotification;
use App\SEOPhase;
use App\Task;
use App\TaskFile;
use App\User;
use App\WireframeFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Get all the tasks for the logged in client
     *
     * @return view with the tasks
     */
    public function index()
    {
        $client = auth()->user();
        // return $user;
        $tasks = Task::where('client_id', auth()->user()->id)->with('design_phase', 'development_phase', 'seo_phase')->get();
        // return $tasks;
        return view('client.home', compact('client', 'tasks'));
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
        return view('client.view_task', compact('task'));
    }

    /**
     * Store a feedback from a client for an
     * individual task
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function store_feedback(Request $request, $id)
    {
        $request->validate([
            'star' => 'required',
            'comment' => 'nullable | max: 250'
        ]);

        $feedback = new ClientFeedback();
        $feedback->task_id = $id;
        $feedback->user_id = auth()->id();
        $feedback->rating = $request->star;
        $feedback->comment = $request->comment;

        $feedback->save();

        // $this->emailUserAndAdmin($id);

        return redirect()->back()->with('success', "Thanks for your feedback");
    }

    /**
     * Delete a feedback
     *
     * @param [type] $id
     * @return void
     */
    public function delete_feedback($id)
    {
        $feedback = ClientFeedback::find($id);
        $feedback->delete();
        return redirect()->back()->with('success', "Your feedback is deleted successfully");
    }

    /**
     * Change password form for client
     *
     * @return void
     */
    public function change_pass()
    {
        return view('client.change_pass');
    }

    /**
     * Store the new password
     *
     * @return void
     */
    public function store_pass(Request $request)
    {
        $request->validate([
            'password' => 'bail | required | min: 6 | confirmed'
        ]);

        $user = User::find(auth()->id());
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', "Your password is changed successfully");
    }

    /**
     * Get All the task-design phase
     *
     * @return projectList
     */
    public function design_phase()
    {
        $tasks = Task::where('client_id', auth()->user()->id)->with('design_phase', 'design_phase.design_pm', 'task_files', 'task_files.wireframe_feedback')->latest()->paginate(6);
        // return $tasks;
        return view('client.design_phase', compact('tasks'));
    }

    /**
     * Get All the task-development phase
     *
     * @return projectList
     */
    public function dev_phase()
    {
        $tasks = Task::where('client_id', auth()->user()->id)->with('development_phase', 'development_phase.dev_pm')->latest()->paginate(6);
        // return $tasks;
        return view('client.dev_phase', compact('tasks'));
    }

    /**
     * Get All the task-seo phase
     *
     * @return projectList
     */
    public function seo_phase()
    {
        $tasks = Task::where('client_id', auth()->user()->id)->with('seo_phase', 'seo_phase.seo_pm')->latest()->paginate(6);
        // return $tasks;
        return view('client.seo_phase', compact('tasks'));
    }

    public function design_feedback(Request $request, $file_id)
    {
        $request->validate([
            'design_feedback' => 'bail | required | max: 250',
        ]);

        $wireframeFeedback = new WireframeFeedback();
        $wireframeFeedback->task_files_id = $file_id;
        $wireframeFeedback->client_id = auth()->user()->id;
        $wireframeFeedback->comment = $request->design_feedback;
        $wireframeFeedback->save();

        $task_files = TaskFile::whereId($file_id)->with('task')->first();
        $task = $task_files->task;

        $this->emailUserAndAdmin($task->id, 'design');
        return redirect()->back()->with('success', "Feedback For task($task->title), WireFrame($task_files->file_title) is added successfully");

    }
    
    /**
     * Delete a Design feedback
     *
     * @param [type] $id
     * @return void
     */
    public function delete_design_feedback($id)
    {
        $feedback = WireframeFeedback::find($id);
        $feedback->delete();
        return redirect()->back()->with('success', "Your feedback is deleted successfully");
    }

    /**
     * Insert Feedback for development Phase
     *
     * @param Request $request
     * @param [type] $dev_id
     * @return void
     */
    public function dev_feedback(Request $request, $dev_id)
    {
        $request->validate([
            'dev_feedback' => 'bail | required | max: 250',
        ]);
        $devPhase = DevelopmentPhase::find($dev_id);
        // return $devPhase;
        $devPhase->dev_feedback = $request->dev_feedback;
        $devPhase->save();

        $this->emailUserAndAdmin($devPhase->task_id, 'development');

        return redirect()->back()->with('success', "Your feedback is added successfully");
    }
    
    /**
     * Delete a dev feedback
     *
     * @param [type] $dev_id
     * @return void
     */
    public function delete_dev_feedback($dev_id)
    {
        $devPhase = DevelopmentPhase::find($dev_id);
        $devPhase->dev_feedback = null;
        $devPhase->save();

        return redirect()->back()->with('success', "Your feedback is deleted successfully");
    }

    /**
     * Insert Feedback for SEO Phase
     *
     * @param Request $request
     * @param [type] $seo_id
     * @return void
     */
    public function seo_feedback(Request $request, $seo_id)
    {
        $request->validate([
            'seo_feedback' => 'bail | required | max: 250',
        ]);
        $seoPhase = SEOPhase::find($seo_id);
        // return $seoPhase;
        $seoPhase->seo_feedback = $request->seo_feedback;
        $seoPhase->save();

        $this->emailUserAndAdmin($seoPhase->task_id, 'seo');

        return redirect()->back()->with('success', "Your feedback is added successfully");
    }
    
    /**
     * Delete a seo feedback
     *
     * @param [type] $seo_id
     * @return void
     */
    public function delete_seo_feedback($seo_id)
    {
        $seoPhase = SEOPhase::find($seo_id);
        $seoPhase->seo_feedback = null;
        $seoPhase->save();

        return redirect()->back()->with('success', "Your feedback is deleted successfully");
    }

    /**
     * Email The assigned PM, PROJECT PM and Admin 
     * After storing a feedback.
     * 
     * @param [type] $task_id
     * @return void
     */
    public function emailUserAndAdmin($task_id, $phase)
    {
        switch ($phase) {
            case 'design':
                $phase_pm = DesignPhase::where('task_id', $task_id)->first();
                $phase_pm_id = $phase_pm->design_pm_id;
                break;

            case 'development':
                $phase_pm = DevelopmentPhase::where('task_id', $task_id)->first();
                $phase_pm_id = $phase_pm->dev_pm_id;
                break;

            case 'seo':
                $phase_pm = SEOPhase::where('task_id', $task_id)->first();
                $phase_pm_id = $phase_pm->seo_pm_id;
                break;
        }

        $task = Task::where('id', $task_id)->with('client')->first();
        $project_pm = User::find($task->project_manager_id);
        $project_pm->notify(new FeedbackNotification($project_pm, $task, $phase));
        $phase_pm_details = User::find($phase_pm_id);
        $project_pm->notify(new FeedbackNotification($phase_pm_details, $task, $phase));
        $admin = User::where('user_type', 0)->first();
        $admin->notify(new FeedbackNotification($admin, $task, $phase));
    }
}