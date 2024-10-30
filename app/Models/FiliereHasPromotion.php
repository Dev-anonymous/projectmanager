<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FiliereHasPromotion
 *
 * @property int $id
 * @property int $filiere_id
 * @property int $promotion_id
 *
 * @property Filiere $filiere
 * @property Promotion $promotion
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class FiliereHasPromotion extends Model
{
    protected $table = 'filiere_has_promotion';
    public $timestamps = false;

    protected $casts = [
        'filiere_id' => 'int',
        'promotion_id' => 'int'
    ];

    protected $fillable = [
        'filiere_id',
        'promotion_id'
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
