<?php
namespace App\Services;

use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProjectService
{
    public function getAllProjects()
    {
        try {
            return Project::with(['tasks' => function ($query) {
                $query->select( 'title', 'description', 'status', 'due_date', 'project_id');
            }])->paginate(10);
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil data proyek.');
        }
    }

    public function createProject($data)
    {
        try {
            return Project::create($data);
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menyimpan data proyek.');
        }
    }

    public function getProjectById($id)
    {
        try {
             $project = Project::with(['tasks' => function ($query) {
                $query->select('title', 'description', 'status', 'due_date', 'project_id');
            }])->findOrFail($id);
            
            return $project;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        }
    }

    public function updateProject($id, $data)
    {
        try {
            $project = Project::findOrFail($id);
            $project->update($data);
            return $project;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui data proyek.');
        }
    }

    public function deleteProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data proyek.');
        }
    }
}
