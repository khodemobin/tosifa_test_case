<?php

namespace App\Models;

use App\Models\Enums\PermissionAction;
use App\Services\PermissionManger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    protected $casts = [
        "fields" => "array",
        "action" => PermissionAction::class
    ];

    protected $guarded = ["id"];

    protected $fillable = [
        "user_id", "model", "action", "fields"
    ];


    /**
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
