<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProjectRequests\StoreProjectRequest;
use App\Http\Requests\ProjectRequests\UpdateProjectRequest;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        try {
            $projects = $this->projectService->getAllProjects();

            return response()->json([
                'status' => 'success',
                'message' => 'Data proyek ditemukan',
                'data' => $projects->items(),
                'total' => $projects->total(),
                'pagination' => [
                    'current_page' => $projects->currentPage(),
                    'total_pages' => $projects->lastPage(),
                    'total_items' => $projects->total(),
                    'per_page' => $projects->perPage(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function store(StoreProjectRequest $request)
    {
        try {
            $project = $this->projectService->createProject($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Proyek berhasil dibuat',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $project = $this->projectService->getProjectById($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data proyek ditemukan',
                'data' => $project,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 404);
        }
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {            
            //* authorization
            $this->authorize('update', $project);

            Log::info('Update Project Request Data:', ['data' => $request->validated()]);

            $this->projectService->updateProject($project, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Proyek berhasil diperbarui',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function destroy(Project $project)
    {
        try {
            //* authorization
            $this->authorize('delete', $project);

            $this->projectService->deleteProject($project);

            return response()->json([
                'status' => 'success',
                'message' => 'Proyek berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}
