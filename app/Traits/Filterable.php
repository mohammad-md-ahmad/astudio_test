<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    /**
     * Apply filters to the query.
     */
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        if ($request->has('filters')) {
            foreach ($request->input('filters') as $attributeName => $filterValue) {
                [$operator, $value] = $this->parseFilterValue($filterValue);

                if (in_array($attributeName, $this->filterableColumns ?? [])) {
                    // Regular column filtering
                    $query->where($attributeName, $operator, $value);
                } else {
                    // EAV attribute filtering
                    $query->whereHas('attributes', function (Builder $query) use ($attributeName, $operator, $value) {
                        $query->whereHas('attribute', function ($subQ) use ($attributeName) {
                            $subQ->where('name', $attributeName);
                        });

                        if ($operator === 'LIKE') {
                            $query->where('value', 'LIKE', "%$value%");
                        } else {
                            $query->where('value', $operator, $value);
                        }
                    });
                }
            }
        }

        return $query;
    }

    /**
     * Parses filter value to extract the operator and value.
     */
    private function parseFilterValue(string $filterValue): array
    {
        if (preg_match('/^(>=|<=|>|<|LIKE) (.+)$/i', $filterValue, $matches)) {
            return [$matches[1], $matches[2]];
        }

        return ['=', $filterValue]; // Default to "=" if no operator is specified
    }
}
