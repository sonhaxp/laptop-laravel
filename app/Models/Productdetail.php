<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Productdetail
 * 
 * @property int $ProductDetailId
 * @property int $ProductId
 * @property int|null $PurchaseDetailId
 * @property int|null $OrderDetailId
 * @property int|null $STT
 * @property string|null $SerialNumber
 * @property Carbon|null $PeriodOfGuarantee
 * 
 * @property Orderdetail|null $orderdetail
 * @property Product $product
 * @property Purchasedetail|null $purchasedetail
 *
 * @package App\Models
 */
class Productdetail extends Model
{
	protected $table = 'productdetail';
	protected $primaryKey = 'ProductDetailId';
	public $timestamps = false;

	protected $casts = [
		'ProductId' => 'int',
		'PurchaseDetailId' => 'int',
		'OrderDetailId' => 'int',
		'STT' => 'int'
	];

	protected $dates = [
		'PeriodOfGuarantee'
	];

	protected $fillable = [
		'ProductId',
		'PurchaseDetailId',
		'OrderDetailId',
		'STT',
		'SerialNumber',
		'PeriodOfGuarantee'
	];

	public function orderdetail()
	{
		return $this->belongsTo(Orderdetail::class, 'OrderDetailId');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductId');
	}

	public function purchasedetail()
	{
		return $this->belongsTo(Purchasedetail::class, 'PurchaseDetailId');
	}
}
