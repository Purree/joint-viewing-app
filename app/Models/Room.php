<?php

namespace App\Models;

use App\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $hidden = [
        'password',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'can_everyone_control' => 'boolean',
        'is_private' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function members(): Collection
    {
        return User::where('current_room_id', $this->id)->get();
    }

    /**
     * @throws UserNotFoundException
     */
    public function kick(User $user): void
    {
        if (! $this->have($user)) {
            throw new UserNotFoundException('User is not in this room.');
        }

        if ($this->owner_id === $user->id && $this->members()->count() > 1) {
            $this->owner_id = $this->members()->except($user->id)->first()->id;
            $this->save();
        }

        if ($this->members()->count() <= 1) {
            $this->delete();
        }

        $user->current_room_id = null;
        $user->save();
    }

    public function have(User $user): bool
    {
        return $this->owner->id === $user->id || $this->members()->contains($user);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getWithOwner(): Room
    {
        return self::when($this->have(\Auth::user()), static function ($query) {
            $query->with('owner');
        })->where('id', $this->id)->first();
    }
}
