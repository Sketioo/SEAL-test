<?php
namespace App\Services;

use Exception;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function updateProject(Project $project, $data)
    {
        try {
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
            $project->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Proyek tidak ditemukan.');
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data proyek.');
        }
    }
}
