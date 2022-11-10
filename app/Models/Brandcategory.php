<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Brandcategory
 * 
 * @property int $BrandCategoryId
 * @property int $CategoryId
 * @property int $BrandId
 * @property string|null $Note
 * @property int $Status
 * 
 * @property Brand $brand
 * @property Category $category
 *
 * @package App\Models
 */
class Brandcategory extends Model
{
	protected $table = 'brandcategory';
	protected $primaryKey = 'BrandCategoryId';
	public $timestamps = false;

	protected $casts = [
		'CategoryId' => 'int',
		'BrandId' => 'int',
		'Status' => 'int'
	];

	protected $fillable = [
		'CategoryId',
		'BrandId',
		'Note',
		'Status'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class, 'BrandId');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'CategoryId');
	}
}
