<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rate
 * 
 * @property int $RateId
 * @property int $ProductId
 * @property int $UserId
 * @property int $Star
 * @property string|null $Comment
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class Rate extends Model
{
	protected $table = 'rate';
	protected $primaryKey = 'RateId';
	public $timestamps = false;

	protected $casts = [
		'ProductId' => 'int',
		'UserId' => 'int',
		'Star' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int'
	];

	protected $dates = [
		'CreateAt',
		'UpdateAt'
	];

	protected $fillable = [
		'ProductId',
		'UserId',
		'Star',
		'Comment',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductId');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'UserId');
	}
}
