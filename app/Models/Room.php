<?php

namespace App\Models;

use App\Services\Results\FunctionResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Room extends Model
{
    use HasFactory;

    protected $hidden = [
        'password',
    ];

    protected $guarded = [
        'id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function queue(): HasMany
    {
        return $this->hasMany(Queue::class);
    }

    public function members(): Collection
    {
        return User::where('current_room_id', $this->id)->get();
    }

    public function kick(User $user): FunctionResult
    {
        if ($user->current_room_id !== $this->id) {
            return FunctionResult::error('User is not in this room.');
        }

        if ($this->owner_id === $user->id) {
            $this->owner_id = $this->members()->except($user->id)->first()->id;
            $this->save();
        }

        if ($this->members()->count() === 1) {
            $this->delete();
        }

        $user->current_room_id = null;
        $user->save();

        return FunctionResult::success();
    }

    public function canJoin(User $user, string $password = null): bool
    {
        return auth('sanctum')->check() &&
            (
                ! $this->is_closed || Hash::check($password, $this->password) ||
                $this->owner->id === $user->id || $this->members()->contains($user)
            );
    }
}
