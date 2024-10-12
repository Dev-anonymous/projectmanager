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
 * @property float|null $montant_cdf
 * @property float|null $montant_usd
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
        'montant_cdf' => 'float',
        'montant_usd' => 'float'
    ];

    protected $fillable = [
        'exportation_id',
        'profil_id',
        'montant_cdf',
        'montant_usd'
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
