<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Projectcriterion
 * 
 * @property int $id
 * @property int $project_id
 * @property string|null $criteria
 * @property float|null $quota
 * 
 * @property Project $project
 *
 * @package App\Models
 */
class Projectcriterion extends Model
{
	protected $table = 'projectcriteria';
	public $timestamps = false;

	protected $casts = [
		'project_id' => 'int',
		'quota' => 'float'
	];

	protected $fillable = [
		'project_id',
		'criteria',
		'quota'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
