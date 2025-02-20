<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Team;

class Player extends Model
{
    protected $fillable = ['name', 'image', 'role'];
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(Team::class, 'team');
    }
}
