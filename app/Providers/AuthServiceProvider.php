<?php

namespace App\Providers;

use App\Models\Enums\PermissionAction;
use App\Models\User;
use App\Services\PermissionManger;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("model-permission", static function (User $user, string $model, array $data, PermissionAction $action) {
            $permissionManger = app()->make(PermissionManger::class);
            $abilities = $permissionManger->getUserPermissionFields($user->id, $model, $action);
            if ($permissionManger->can($data, $abilities)) {
                return Response::allow();
            }

            return Response::deny("Allowed fields: " . implode(", ", $abilities));
        });
    }
}
