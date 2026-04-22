<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PollOption;
use Illuminate\Support\Str;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'created_by', 'expires_at'];

    public function pollOptions()
    {
        return $this->hasMany(PollOption::class);
    }

    protected static function booted()
    {
        static::creating(function ($poll) {
            $poll->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
