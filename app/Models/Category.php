<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $CategoryId
 * @property string $Name
 * @property string|null $Description
 * @property int|null $ParentCategoryId
 * @property string|null $Url
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * @property string|null $Image
 * 
 * @property Category|null $category
 * @property Collection|Attribute[] $attributes
 * @property Collection|Brand[] $brands
 * @property Collection|Category[] $categories
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'category';
	protected $primaryKey = 'CategoryId';
	public $timestamps = false;

	protected $casts = [
		'ParentCategoryId' => 'int',
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
		'Description',
		'ParentCategoryId',
		'Url',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy',
		'Image'
	];

	public function category()
	{
		return $this->belongsTo(Category::class, 'ParentCategoryId');
	}

	public function attributes()
	{
		return $this->belongsToMany(Attribute::class, 'attributecategory', 'CategoryId', 'AttributeId')
					->withPivot('AttributeCategoryId', 'Note', 'Status');
	}

	public function brands()
	{
		return $this->belongsToMany(Brand::class, 'brandcategory', 'CategoryId', 'BrandId')
					->withPivot('BrandCategoryId', 'Note', 'Status');
	}

	public function categories()
	{
		return $this->hasMany(Category::class, 'ParentCategoryId');
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'CategoryId');
	}
}
