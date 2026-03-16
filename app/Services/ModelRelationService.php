<?php

namespace App\Services;

use ReflectionClass;
use ReflectionMethod;
use Illuminate\Database\Eloquent\Relations\Relation;

class ModelRelationService
{
    // public function getRelations(string $modelClass, array $visited = []): array
    // {
    //     $relations = [];

    //     $reflection = new ReflectionClass($modelClass);

    //     foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

    //         if ($method->class !== $modelClass) {
    //             continue;
    //         }

    //         if ($method->getNumberOfParameters() > 0) {
    //             continue;
    //         }

    //         try {

    //             $instance = new $modelClass;

    //             $return = $method->invoke($instance);

    //             if ($return instanceof Relation) {

    //                 $related = get_class($return->getRelated());

    //                 // prevent circular relation
    //                 if (in_array($related, $visited)) {
    //                     continue;
    //                 }

    //                 $relations[$method->getName()] = $related;
    //             }

    //         } catch (\Throwable $e) {
    //             continue;
    //         }
    //     }

    //     return $relations;
    // }

     public function getRelations(string $modelClass, array $visited = []): array
    {
        $relations = [];

        // Allowed models from registry
        $allowedModels = array_values(ModelRegistry::all());

        $reflection = new ReflectionClass($modelClass);

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

            if ($method->class !== $modelClass) {
                continue;
            }

            if ($method->getNumberOfParameters() > 0) {
                continue;
            }

            try {

                $instance = new $modelClass;

                $return = $method->invoke($instance);

                if ($return instanceof Relation) {

                    $related = get_class($return->getRelated());

                    // prevent circular relation
                    if (in_array($related, $visited)) {
                        continue;
                    }

                    // ONLY allow relations present in ModelRegistry
                    if (!in_array($related, $allowedModels)) {
                        continue;
                    }

                    $relations[$method->getName()] = $related;
                }

            } catch (\Throwable $e) {
                continue;
            }
        }

        return $relations;
    }
}