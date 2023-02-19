<?php

namespace App\Models;

use App\Models\Enums\PermissionAction;
use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use  HasPermission;

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
