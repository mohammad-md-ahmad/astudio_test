<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AttributeServiceInterface;
use App\Http\Requests\Attributes\CreateAttributeRequest;
use App\Http\Requests\Attributes\UpdateAttributeRequest;
use App\Models\Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttributeService implements AttributeServiceInterface
{
    public function get(Attribute $attribute): Attribute
    {
        try {
            return $attribute;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function getAll(Request $request): Collection
    {
        try {
            return Attribute::all();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function create(CreateAttributeRequest $request): Attribute
    {
        try {
            return DB::transaction(function () use ($request) {
                $attribute = new Attribute;
                $attribute->fill($request->only($attribute->getFillable()));
                $attribute->save();

                return $attribute;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute): Attribute
    {
        try {
            $attribute->fill($request->only($attribute->getFillable()));
            $attribute->save();

            return $attribute;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function delete(Attribute $attribute): bool
    {
        try {
            $attribute->values()->delete();

            return $attribute->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
