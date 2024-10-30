<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskHasUser
 *
 * @property int $task_id
 * @property int $users_id
 *
 * @property Task $task
 * @property User $user
 *
 * @package App\Models
 */
class TaskHasUser extends Model
{
    protected $table = 'task_has_users';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'task_id' => 'int',
        'users_id' => 'int'
    ];

    protected $fillable = [
        'users_id',
        'task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
