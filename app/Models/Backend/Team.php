<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Player;

class Team extends Model
{
    protected $fillable = ['name', 'image'];
    use HasFactory;

    public function players()
    {
        return $this->hasMany(Player::class, 'team');
    }
}
