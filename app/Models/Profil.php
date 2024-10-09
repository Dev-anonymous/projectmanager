<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profil
 * 
 * @property int $id
 * @property int $users_id
 * @property string|null $typepiece
 * @property string|null $pieceidentite
 * @property string|null $adresse
 * @property float|null $solde_usd
 * @property float|null $solde_cdf
 * 
 * @property User $user
 * @property Collection|Depot[] $depots
 *
 * @package App\Models
 */
class Profil extends Model
{
	protected $table = 'profil';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int',
		'solde_usd' => 'float',
		'solde_cdf' => 'float'
	];

	protected $fillable = [
		'users_id',
		'typepiece',
		'pieceidentite',
		'adresse',
		'solde_usd',
		'solde_cdf'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}

	public function depots()
	{
		return $this->hasMany(Depot::class);
	}
}
