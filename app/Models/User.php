<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $UserId
 * @property string $UserName
 * @property string|null $Password
 * @property string $Name
 * @property string|null $Email
 * @property string|null $PhoneNumber
 * @property string|null $Gender
 * @property Carbon|null $Birthday
 * @property string|null $Address
 * @property string|null $Image
 * @property int $RoleId
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * @property Carbon|null $LastLogin
 * 
 * @property Attributevalue $attributevalue
 * @property Collection|Article[] $articles
 * @property Collection|Feedback[] $feedback
 * @property Collection|Order[] $orders
 * @property Collection|Purchase[] $purchases
 * @property Collection|Rate[] $rates
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'UserId';
	public $timestamps = false;

	protected $casts = [
		'RoleId' => 'int',
		'Status' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int'
	];

	protected $dates = [
		'Birthday',
		'CreateAt',
		'UpdateAt',
		'LastLogin'
	];

	protected $fillable = [
		'UserName',
		'Password',
		'Name',
		'Email',
		'PhoneNumber',
		'Gender',
		'Birthday',
		'Address',
		'Image',
		'RoleId',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy',
		'LastLogin'
	];

	public function attributevalue()
	{
		return $this->belongsTo(Attributevalue::class, 'RoleId');
	}

	public function articles()
	{
		return $this->hasMany(Article::class, 'UserId');
	}

	public function feedback()
	{
		return $this->hasMany(Feedback::class, 'UserId');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'UserId');
	}

	public function purchases()
	{
		return $this->hasMany(Purchase::class, 'SupplierId');
	}

	public function rates()
	{
		return $this->hasMany(Rate::class, 'UserId');
	}
}
