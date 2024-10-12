<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Exportation
 * 
 * @property int $id
 * @property int $users_id
 * @property float|null $montant_cdf
 * @property float|null $montant_usd
 * @property int|null $etat
 * @property Carbon|null $date
 * @property Carbon|null $datevalidation
 * 
 * @property User $user
 * @property Collection|Profil[] $profils
 *
 * @package App\Models
 */
class Exportation extends Model
{
	protected $table = 'exportation';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int',
		'montant_cdf' => 'float',
		'montant_usd' => 'float',
		'etat' => 'int',
		'date' => 'datetime',
		'datevalidation' => 'datetime'
	];

	protected $fillable = [
		'users_id',
		'montant_cdf',
		'montant_usd',
		'etat',
		'date',
		'datevalidation'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}

	public function profils()
	{
		return $this->belongsToMany(Profil::class, 'exportation_has_profil')
					->withPivot('montant', 'devise');
	}
}
