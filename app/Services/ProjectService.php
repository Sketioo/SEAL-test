<?php

namespace App\Services;

use Exception;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class ProjectService
{
    public function getAllProjects()
    {
        try {
            return Cache::remember('projects_all', now()->addMinutes(10), function () {
                return Project::with(['tasks' => function ($query) {
                    $query->select('title', 'description', 'status', 'due_date', 'project_id');
                }])->paginate(10);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil data proyek.');
        }
    }

    public function createProject($data)
    {
        try {
            //* Clear cache when a new project is created
            Cache::forget('projects_all');
            return Project::create($data);
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menyimpan data proyek.');
        }
    }

    public function getProjectById($id)
    {
        try {
            return Cache::remember("project_{$id}", now()->addMinutes(10), function () use ($id) {
                return Project::with(['tasks' => function ($query) {
                    $query->select('title', 'description', 'status', 'due_date', 'project_id');
                }])->findOrFail($id);
            });
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        }
    }

    public function updateProject(Project $project, $data)
    {
        try {
            //* Clear specific project cache
            Cache::forget("project_{$project->id}");
            Cache::forget('projects_all');

            $project->update($data);

            return $project;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui data proyek.');
        }
    }

    public function deleteProject(Project $project)
    {
        try {
            //* Clear specific project cache
            Cache::forget("project_{$project->id}");
            Cache::forget('projects_all');

            $project->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data proyek.');
        }
    }
}
