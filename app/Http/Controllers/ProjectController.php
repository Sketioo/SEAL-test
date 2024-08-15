<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data proyek ditemukan',
            'data' => $projects->items(),
            'pagination' => [
                'current_page' => $projects->currentPage(),
                'total_pages' => $projects->lastPage(),
                'total_items' => $projects->total(),
                'per_page' => $projects->perPage(),
            ],
        ]);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek berhasil dibuat',
        ]);
    }

    public function show(Project $project)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data proyek ditemukan',
            'data' => $project,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek berhasil diperbarui',
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek berhasil dihapus',
        ]);
    }
}
