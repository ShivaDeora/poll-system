<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PollOption;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'created_by', 'expires_at'];

    public function pollOptions()
    {
        return $this->hasMany(PollOption::class);
    }
}
