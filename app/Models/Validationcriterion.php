<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Validationcriterion
 * 
 * @property int $id
 * @property string|null $criteria
 *
 * @package App\Models
 */
class Validationcriterion extends Model
{
	protected $table = 'validationcriteria';
	public $timestamps = false;

	protected $fillable = [
		'criteria'
	];
}
