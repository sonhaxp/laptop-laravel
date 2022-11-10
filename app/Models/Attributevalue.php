<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attributevalue
 * 
 * @property int $AttributeValueId
 * @property int $AttributeId
 * @property string $Value
 * @property int $Status
 * 
 * @property Attribute $attribute
 * @property Collection|Attributedetail[] $attributedetails
 * @property Collection|Classifygroupoption[] $classifygroupoptions
 * @property Collection|Order[] $orders
 * @property Collection|Purchase[] $purchases
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Attributevalue extends Model
{
	protected $table = 'attributevalue';
	protected $primaryKey = 'AttributeValueId';
	public $timestamps = false;

	protected $casts = [
		'AttributeId' => 'int',
		'Status' => 'int'
	];

	protected $fillable = [
		'AttributeId',
		'Value',
		'Status'
	];

	public function attribute()
	{
		return $this->belongsTo(Attribute::class, 'AttributeId');
	}

	public function attributedetails()
	{
		return $this->hasMany(Attributedetail::class, 'ValueId');
	}

	public function classifygroupoptions()
	{
		return $this->hasMany(Classifygroupoption::class, 'ValueId');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'Status');
	}

	public function purchases()
	{
		return $this->hasMany(Purchase::class, 'Status');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'RoleId');
	}
}
