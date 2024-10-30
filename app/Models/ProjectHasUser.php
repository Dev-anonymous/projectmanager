<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectHasUser
 *
 * @property int $project_id
 * @property int $users_id
 *
 * @property Project $project
 * @property User $user
 *
 * @package App\Models
 */
class ProjectHasUser extends Model
{
    protected $table = 'project_has_users';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'project_id' => 'int',
        'users_id' => 'int'
    ];

    protected $fillable = [
        'project_id',
        'users_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
