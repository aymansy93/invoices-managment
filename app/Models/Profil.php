<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $table = 'profils';
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'username',
        'role',
        'description',
        'image_path',
        'github',
        'twitter',
        'linkedin',
        'facebook',
    ];

 public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
