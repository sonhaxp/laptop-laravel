<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attributedetail
 * 
 * @property int $AttributeDetailId
 * @property int $AttributeId
 * @property int $ProductId
 * @property int $ValueId
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Attribute $attribute
 * @property Attributevalue $attributevalue
 * @property Product $product
 *
 * @package App\Models
 */
class Attributedetail extends Model
{
	protected $table = 'attributedetail';
	protected $primaryKey = 'AttributeDetailId';
	public $timestamps = false;

	protected $casts = [
		'AttributeId' => 'int',
		'ProductId' => 'int',
		'ValueId' => 'int',
		'Status' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int'
	];

	protected $dates = [
		'CreateAt',
		'UpdateAt'
	];

	protected $fillable = [
		'AttributeId',
		'ProductId',
		'ValueId',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function attribute()
	{
		return $this->belongsTo(Attribute::class, 'AttributeId');
	}

	public function attributevalue()
	{
		return $this->belongsTo(Attributevalue::class, 'ValueId');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductId');
	}
}
