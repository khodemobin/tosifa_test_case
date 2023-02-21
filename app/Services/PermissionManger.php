<?php

namespace App\Services;

use App\Models\Enums\PermissionAction;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PermissionManger
{
    private static array $returnData = [];


    public function removeUnAuthorizeFieldsFromCollection(Collection $data, PermissionAction $action): array
    {
        $returnData = [];
        foreach ($data as $item) {
            $returnData[] = $this->removeUnAuthorizeFieldsFromModel($item, $action);
        }
        return $returnData;
    }

    public function removeUnAuthorizeFieldsFromModel(Model $model, PermissionAction $action)
    {
        $abilities = $this->getUserPermissionFields($model?->user_id, $model::class, $action);
        $newModel = new (get_class($model));
        $items = json_decode($model, true, 512, JSON_THROW_ON_ERROR);

        foreach ($items as $key => $t) {
            if (in_array($key, $abilities, true) || in_array("*", $abilities, true)) {
                $newModel->{$key} = $t;
            }
        }

        return $newModel;
    }


    public function can(array $data, array $abilities): bool
    {
        if (in_array("*", $abilities, true)) {
            return true;
        }

        foreach ($data as $key => $item) {
            if ($key === "user_id") {
                continue;
            }

            if (!in_array($key, $abilities, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * return user's permissions by model and action in one array
     */
    public function getUserPermissionFields(int $userId, string $model, PermissionAction $action): array
    {
        $permissions = $this->getPermissions($userId);
        $permissions = collect($permissions)
            ->where("model", $model)
            ->where("action", $action->value);

        return $permissions->pluck("fields")->flatten()->toArray();
    }

    private function getPermissions($userId): array
    {
        return Permission::query()
            ->where("user_id", $userId)
            ->orWhereNull("user_id")
            ->get()
            ->toArray();
    }
}
