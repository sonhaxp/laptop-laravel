<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $OrderId
 * @property int $UserId
 * @property int|null $EmployeeId
 * @property string|null $DisplayName
 * @property string|null $Receiver
 * @property string|null $Address
 * @property string|null $PhoneNumber
 * @property string|null $Email
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Attributevalue $attributevalue
 * @property User $user
 * @property Collection|Orderdetail[] $orderdetails
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
	protected $primaryKey = 'OrderId';
	public $timestamps = false;

	protected $casts = [
		'UserId' => 'int',
		'EmployeeId' => 'int',
		'Status' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int'
	];

	protected $dates = [
		'CreateAt',
		'UpdateAt'
	];

	protected $fillable = [
		'UserId',
		'EmployeeId',
		'DisplayName',
		'Receiver',
		'Address',
		'PhoneNumber',
		'Email',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function attributevalue()
	{
		return $this->belongsTo(Attributevalue::class, 'Status');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'UserId');
	}

	public function orderdetails()
	{
		return $this->hasMany(Orderdetail::class, 'OrderId');
	}
}
