<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Depot
 * 
 * @property int $id
 * @property int $profil_id
 * @property int|null $users_id
 * @property string $agentname
 * @property string $type
 * @property float $montant_cdf
 * @property float $montant_usd
 * @property string $devise_depot
 * @property Carbon $date
 * @property string|null $ref
 * @property float|null $commission
 * 
 * @property Profil $profil
 * @property User|null $user
 *
 * @package App\Models
 */
class Depot extends Model
{
	protected $table = 'depot';
	public $timestamps = false;

	protected $casts = [
		'profil_id' => 'int',
		'users_id' => 'int',
		'montant_cdf' => 'float',
		'montant_usd' => 'float',
		'date' => 'datetime',
		'commission' => 'float'
	];

	protected $fillable = [
		'profil_id',
		'users_id',
		'agentname',
		'type',
		'montant_cdf',
		'montant_usd',
		'devise_depot',
		'date',
		'ref',
		'commission'
	];

	public function profil()
	{
		return $this->belongsTo(Profil::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}
}
