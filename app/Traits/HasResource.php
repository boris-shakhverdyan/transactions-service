<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use RuntimeException;

trait HasResource
{
    /**
     * Defines and returns an API resource for a model.
     */
    public function toResource(): JsonResource
    {
        $resourceClass = $this->getResourceClass();
        return new $resourceClass($this);
    }

    /**
     * Defines and returns a collection of API resources for a model.
     */
    public static function toResourceCollection(Collection|array $items): JsonResource
    {
        if ($items instanceof Collection && $items->isEmpty()) {
            return new JsonResource([]);
        }

        /** @var JsonResource $resourceClass */
        $resourceClass = (new static)->getResourceClass();
        return $resourceClass::collection($items);
    }

    /**
     * Gets the name of the Resource class for the current model.
     */
    private function getResourceClass(): string
    {
        $modelClass = get_class($this);
        $resourceClass = str_replace('Models', 'Http\Resources', $modelClass) . 'Resource';

        if (!class_exists($resourceClass)) {
            throw new RuntimeException("Resource class [$resourceClass] not found.");
        }

        return $resourceClass;
    }
}
