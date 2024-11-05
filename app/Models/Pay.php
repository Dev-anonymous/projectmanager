<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pay
 *
 * @property int $id
 * @property string $ref
 * @property string|null $myref
 * @property int|null $failed
 * @property int|null $saved
 * @property string|null $data
 * @property Carbon|null $date
 *
 * @package App\Models
 */
class Pay extends Model
{
    protected $table = 'pay';
    public $timestamps = false;

    protected $casts = [
        'failed' => 'int',
        'saved' => 'int',
        'date' => 'datetime'
    ];

    protected $fillable = [
        'ref',
        'myref',
        'failed',
        'saved',
        'data',
        'date'
    ];
}
