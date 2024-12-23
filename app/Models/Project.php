<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * 
 * @property int $id
 * @property string|null $name
 * @property float|null $budget
 * @property Carbon|null $startdate
 * @property Carbon|null $enddate
 * @property int|null $status
 * @property string|null $description
 * @property int|null $valide
 * @property float|null $quote
 * 
 * @property Collection|Product[] $products
 * @property Collection|User[] $users
 * @property Collection|Projectcriterion[] $projectcriteria
 * @property Collection|Task[] $tasks
 *
 * @package App\Models
 */
class Project extends Model
{
	protected $table = 'project';
	public $timestamps = false;

	protected $casts = [
		'budget' => 'float',
		'startdate' => 'datetime',
		'enddate' => 'datetime',
		'status' => 'int',
		'valide' => 'int',
		'quote' => 'float'
	];

	protected $fillable = [
		'name',
		'budget',
		'startdate',
		'enddate',
		'status',
		'description',
		'valide',
		'quote'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'project_has_users', 'project_id', 'users_id');
	}

	public function projectcriteria()
	{
		return $this->hasMany(Projectcriterion::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
