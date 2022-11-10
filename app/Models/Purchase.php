<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Purchase
 * 
 * @property int $PurchaseId
 * @property int|null $SupplierId
 * @property int $EmployeeId
 * @property string|null $DisplayName
 * @property string|null $Deliver
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
 * @property User|null $user
 * @property Collection|Purchasedetail[] $purchasedetails
 *
 * @package App\Models
 */
class Purchase extends Model
{
	protected $table = 'purchase';
	protected $primaryKey = 'PurchaseId';
	public $timestamps = false;

	protected $casts = [
		'SupplierId' => 'int',
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
		'SupplierId',
		'EmployeeId',
		'DisplayName',
		'Deliver',
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
		return $this->belongsTo(User::class, 'SupplierId');
	}
	public function supplier()
	{
		return $this->belongsTo(User::class, 'EmployeeId');
	}
	public function purchasedetails()
	{
		return $this->hasMany(Purchasedetail::class, 'PurchaseId');
	}
}
