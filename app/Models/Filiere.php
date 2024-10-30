<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Filiere
 * 
 * @property int $id
 * @property string|null $filiere
 * 
 * @property Collection|Promotion[] $promotions
 *
 * @package App\Models
 */
class Filiere extends Model
{
	protected $table = 'filiere';
	public $timestamps = false;

	protected $fillable = [
		'filiere'
	];

	public function promotions()
	{
		return $this->belongsToMany(Promotion::class, 'filiere_has_promotion')
					->withPivot('id');
	}
}
