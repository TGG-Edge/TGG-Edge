<?php
namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CollectionPaginationService
{
    public function paginate(array|Collection $items, int $perPage = 10, int $page = null, array $options = [])
    {
        $page = $page ?: request()->get('page', 1);
        $items = is_array($items) ? collect($items) : $items;

        $sliced = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $sliced,
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
