<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pending
 * 
 * @property int $id
 * @property string|null $text
 * @property string|null $to
 * @property int|null $retry
 *
 * @package App\Models
 */
class Pending extends Model
{
	protected $table = 'pending';
	public $timestamps = false;

	protected $casts = [
		'retry' => 'int'
	];

	protected $fillable = [
		'text',
		'to',
		'retry'
	];
}
