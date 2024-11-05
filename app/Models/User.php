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
 * @property int|null $filiere_has_promotion_id
 * @property int|null $users_id
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
 *
 * @property FiliereHasPromotion|null $filiere_has_promotion
 * @property User|null $user
 * @property Collection|Cart[] $carts
 * @property Collection|Commande[] $commandes
 * @property Collection|Project[] $projects
 * @property Collection|Task[] $tasks
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $casts = [
        'filiere_has_promotion_id' => 'int',
        'users_id' => 'int',
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'filiere_has_promotion_id',
        'users_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'user_role',
        'phone',
        'image'
    ];

    public function filiere_has_promotion()
    {
        return $this->belongsTo(FiliereHasPromotion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'users_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'users_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_has_users', 'users_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_has_users', 'users_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'users_id');
    }
}
