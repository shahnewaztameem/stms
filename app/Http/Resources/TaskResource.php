<?php

namespace App\Http\Resources;

use App\Http\Resources\FileResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'details' => $this->details,
            'created_at' => $this->created_at->diffForhumans(),
            'feedback' => new FeedbackResource($this->feedback),
            'users' => UserResource::collection($this->users),
            'task_files' => FileResource::collection($this->task_files),
        ];
    }
}
