<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property int $category_id
 * @property int|null $project_id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $price
 * @property string|null $images
 * @property int|null $forsale
 * @property int|null $stock
 * @property Carbon|null $date
 * @property Carbon|null $updatedon
 *
 * @property Category $category
 * @property Project|null $project
 *
 * @package App\Models
 */
class Product extends Model
{
    protected $table = 'product';
    public $timestamps = false;

    protected $casts = [
        'category_id' => 'int',
        'project_id' => 'int',
        'price' => 'float',
        'forsale' => 'int',
        'stock' => 'int',
        'date' => 'datetime',
        'updatedon' => 'datetime'
    ];

    protected $fillable = [
        'category_id',
        'project_id',
        'name',
        'description',
        'price',
        'images',
        'forsale',
        'stock',
        'date',
        'updatedon'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
