<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commande
 * 
 * @property int $id
 * @property int $users_id
 * @property string|null $articles
 * @property float|null $total_cdf
 * @property Carbon|null $date
 * @property string|null $ref
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Commande extends Model
{
	protected $table = 'commande';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int',
		'total_cdf' => 'float',
		'date' => 'datetime'
	];

	protected $fillable = [
		'users_id',
		'articles',
		'total_cdf',
		'date',
		'ref'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}
}
