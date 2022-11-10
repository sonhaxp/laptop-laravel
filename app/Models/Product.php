<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $ProductId
 * @property string $Name
 * @property string $ShortName
 * @property int|null $Price
 * @property float|null $Discount
 * @property int $CategoryId
 * @property int $BrandId
 * @property int|null $ProductParentId
 * @property string|null $Url
 * @property string|null $Description
 * @property string|null $Image
 * @property int|null $Group1
 * @property int|null $Group2
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * @property int|null $PeriodOfGuarantee
 * @property int|null $Quantity
 * 
 * @property Brand $brand
 * @property Category $category
 * @property Classifygroupoption|null $classifygroupoption
 * @property Product|null $product
 * @property Collection|Attributedetail[] $attributedetails
 * @property Collection|Classifygroup[] $classifygroups
 * @property Collection|Orderdetail[] $orderdetails
 * @property Collection|Product[] $products
 * @property Collection|Productdetail[] $productdetails
 * @property Collection|Purchasedetail[] $purchasedetails
 * @property Collection|Rate[] $rates
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'product';
	protected $primaryKey = 'ProductId';
	public $timestamps = false;

	protected $casts = [
		'Price' => 'int',
		'Discount' => 'float',
		'CategoryId' => 'int',
		'BrandId' => 'int',
		'ProductParentId' => 'int',
		'Group1' => 'int',
		'Group2' => 'int',
		'Status' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int',
		'PeriodOfGuarantee' => 'int',
		'Quantity' => 'int'
	];

	protected $dates = [
		'CreateAt',
		'UpdateAt'
	];

	protected $fillable = [
		'Name',
		'ShortName',
		'Price',
		'Discount',
		'CategoryId',
		'BrandId',
		'ProductParentId',
		'Url',
		'Description',
		'Image',
		'Group1',
		'Group2',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy',
		'PeriodOfGuarantee',
		'Quantity'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class, 'BrandId');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'CategoryId');
	}

	public function classifygroupoption()
	{
		return $this->belongsTo(Classifygroupoption::class, 'Group2');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductParentId');
	}

	public function attributedetails()
	{
		return $this->hasMany(Attributedetail::class, 'ProductId');
	}

	public function classifygroups()
	{
		return $this->hasMany(Classifygroup::class, 'ProductId', 'ProductID');
	}

	public function orderdetails()
	{
		return $this->hasMany(Orderdetail::class, 'ProductId');
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'ProductParentId');
	}

	public function productdetails()
	{
		return $this->hasMany(Productdetail::class, 'ProductId');
	}

	public function purchasedetails()
	{
		return $this->hasMany(Purchasedetail::class, 'ProductId');
	}

	public function rates()
	{
		return $this->hasMany(Rate::class, 'ProductId');
	}
}
