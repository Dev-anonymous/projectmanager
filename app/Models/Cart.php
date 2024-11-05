<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * 
 * @property int $id
 * @property int $product_id
 * @property int $users_id
 * @property int|null $qty
 * 
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class Cart extends Model
{
	protected $table = 'cart';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'users_id' => 'int',
		'qty' => 'int'
	];

	protected $fillable = [
		'product_id',
		'users_id',
		'qty'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}
}
