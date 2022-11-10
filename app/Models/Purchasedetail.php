<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Purchasedetail
 * 
 * @property int $PurchaseDetailId
 * @property int $PurchaseId
 * @property int $ProductId
 * @property int|null $Quantity
 * @property int|null $Price
 * 
 * @property Product $product
 * @property Purchase $purchase
 * @property Collection|Productdetail[] $productdetails
 *
 * @package App\Models
 */
class Purchasedetail extends Model
{
	protected $table = 'purchasedetail';
	protected $primaryKey = 'PurchaseDetailId';
	public $timestamps = false;

	protected $casts = [
		'PurchaseId' => 'int',
		'ProductId' => 'int',
		'Quantity' => 'int',
		'Price' => 'int'
	];

	protected $fillable = [
		'PurchaseId',
		'ProductId',
		'Quantity',
		'Price'
	];

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductId');
	}

	public function purchase()
	{
		return $this->belongsTo(Purchase::class, 'PurchaseId');
	}

	public function productdetails()
	{
		return $this->hasMany(Productdetail::class, 'PurchaseDetailId');
	}
}
