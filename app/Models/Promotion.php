<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Promotion
 * 
 * @property int $id
 * @property string|null $promotion
 * 
 * @property Collection|Filiere[] $filieres
 *
 * @package App\Models
 */
class Promotion extends Model
{
	protected $table = 'promotion';
	public $timestamps = false;

	protected $fillable = [
		'promotion'
	];

	public function filieres()
	{
		return $this->belongsToMany(Filiere::class, 'filiere_has_promotion')
					->withPivot('id');
	}
}
