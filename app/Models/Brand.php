<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property int $BrandId
 * @property string $Name
 * @property int|null $BrandParentId
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Brand|null $brand
 * @property Collection|Brand[] $brands
 * @property Collection|Category[] $categories
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brand';
	protected $primaryKey = 'BrandId';
	public $timestamps = false;

	protected $casts = [
		'BrandParentId' => 'int',
		'Status' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int'
	];

	protected $dates = [
		'CreateAt',
		'UpdateAt'
	];

	protected $fillable = [
		'Name',
		'BrandParentId',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class, 'BrandParentId');
	}

	public function brands()
	{
		return $this->hasMany(Brand::class, 'BrandParentId');
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'brandcategory', 'BrandId', 'CategoryId')
					->withPivot('BrandCategoryId', 'Note', 'Status');
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'BrandId');
	}
}
