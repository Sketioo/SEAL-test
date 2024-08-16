<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => 'Data proyek ditemukan',
            'data' => $this->collection,
            'total' => $this->total(),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'total_items' => $this->total(),
                'per_page' => $this->perPage(),
            ],
        ];
    }
}
