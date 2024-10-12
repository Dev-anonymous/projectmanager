<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property int|null $users_id
 * @property int|null $categorie_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $user_role
 * @property string|null $phone
 * @property string|null $image
 * @property string|null $code
 *
 * @property Categorie|null $categorie
 * @property User|null $user
 * @property Collection|Depot[] $depots
 * @property Collection|Exportation[] $exportations
 * @property Collection|Profil[] $profils
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $casts = [
        'users_id' => 'int',
        'categorie_id' => 'int',
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'users_id',
        'categorie_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'user_role',
        'phone',
        'image',
        'code'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function depots()
    {
        return $this->hasMany(Depot::class, 'users_id');
    }

    public function exportations()
    {
        return $this->hasMany(Exportation::class, 'users_id');
    }

    public function profils()
    {
        return $this->hasMany(Profil::class, 'users_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'users_id');
    }
}
