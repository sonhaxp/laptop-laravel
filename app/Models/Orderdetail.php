<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Orderdetail
 * 
 * @property int $OrderDetailId
 * @property int $OrderId
 * @property int $ProductId
 * @property int $Quantity
 * @property int $Price
 * @property int|null $Discount
 * 
 * @property Order $order
 * @property Product $product
 * @property Collection|Productdetail[] $productdetails
 *
 * @package App\Models
 */
class Orderdetail extends Model
{
	protected $table = 'orderdetail';
	protected $primaryKey = 'OrderDetailId';
	public $timestamps = false;

	protected $casts = [
		'OrderId' => 'int',
		'ProductId' => 'int',
		'Quantity' => 'int',
		'Price' => 'int',
		'Discount' => 'int'
	];

	protected $fillable = [
		'OrderId',
		'ProductId',
		'Quantity',
		'Price',
		'Discount'
	];

	public function order()
	{
		return $this->belongsTo(Order::class, 'OrderId');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductId');
	}

	public function productdetails()
	{
		return $this->hasMany(Productdetail::class, 'OrderDetailId');
	}
}
