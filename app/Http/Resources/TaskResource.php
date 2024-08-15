<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'user' => new UserResource($this->whenLoaded('user')), 
            'project' => new ProjectResource($this->whenLoaded('project')), 
        ];
    }
}
