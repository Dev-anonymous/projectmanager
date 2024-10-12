<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExportationHasProfil
 * 
 * @property int $exportation_id
 * @property int $profil_id
 * @property float|null $montant
 * @property string|null $devise
 * 
 * @property Exportation $exportation
 * @property Profil $profil
 *
 * @package App\Models
 */
class ExportationHasProfil extends Model
{
	protected $table = 'exportation_has_profil';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'exportation_id' => 'int',
		'profil_id' => 'int',
		'montant' => 'float'
	];

	protected $fillable = [
		'montant',
		'devise'
	];

	public function exportation()
	{
		return $this->belongsTo(Exportation::class);
	}

	public function profil()
	{
		return $this->belongsTo(Profil::class);
	}
}
