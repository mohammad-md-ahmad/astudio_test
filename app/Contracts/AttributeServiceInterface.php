<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Attributes\CreateAttributeRequest;
use App\Http\Requests\Attributes\SetAttributeValueRequest;
use App\Http\Requests\Attributes\UpdateAttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface AttributeServiceInterface
{
    public function get(Attribute $attribute): Attribute;

    public function getAll(Request $request): Collection;

    public function create(CreateAttributeRequest $request): Attribute;

    public function update(UpdateAttributeRequest $request, Attribute $attribute): Attribute;

    public function delete(Attribute $attribute): bool;

    public function setAttributeValue(SetAttributeValueRequest $request): bool;
}
