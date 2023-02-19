<?php

namespace App\Traits;

use App\Models\Enums\PermissionAction;
use App\Models\Permission;
use Illuminate\Support\Collection;

trait HasPermission
{
    private static array $returnData = [];

    public static function checkPermissionForData($data, PermissionAction $action)
    {
        if (is_array($data)) {
            foreach ($data as $item) {
                self::$returnData[] = self::checkPermissionForData($item, $action);
            }
            return self::$returnData;
        }

        $fields = self::getPermissionFields($data, $action);
        $items = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        foreach ($items as $key => $t) {
            if (!in_array($key, $fields, true) && !in_array("*", $fields, true)) {
                unset($items[$key]);
            }
        }

        return $items;
    }

    private static function checkPermissionForModel($data, PermissionAction $action)
    {
        if (is_array($data) || $data instanceof Collection) {
            foreach ($data as $item) {
                self::$returnData[] = self::checkPermissionForModel($item, $action);
            }
            return self::$returnData;
        }

        $fields = self::getPermissionFields($data, $action);
        $model = new (get_class($data));
        $items = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        foreach ($items as $key => $t) {
            if (in_array($key, $fields, true) || in_array("*", $fields, true)) {
                $model->{$key} = $t;
            }
        }

        return $model;
    }

    private static function getPermissionFields($model, PermissionAction $action): array
    {
        $permissions = self::getPermissions($model->user_id);
        $permissions = collect($permissions)
            ->where("model", $model::class)
            ->where("action", $action->value);

        return $permissions->pluck("fields")->flatten()->toArray();
    }

    private static function getPermissions($userId): array
    {
        return Permission::query()
            ->where("user_id", $userId)
            ->orWhereNull("user_id")
            ->get()
            ->toArray();
    }
}
