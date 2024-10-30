<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * 
 * @property int $id
 * @property int $project_id
 * @property string|null $name
 * @property string|null $description
 * @property Carbon|null $startdate
 * @property Carbon|null $enddate
 * @property int|null $status
 * 
 * @property Project $project
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Task extends Model
{
	protected $table = 'task';
	public $timestamps = false;

	protected $casts = [
		'project_id' => 'int',
		'startdate' => 'datetime',
		'enddate' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'project_id',
		'name',
		'description',
		'startdate',
		'enddate',
		'status'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'task_has_users', 'task_id', 'users_id');
	}
}
