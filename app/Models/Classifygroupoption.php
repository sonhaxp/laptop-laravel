<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classifygroupoption
 * 
 * @property int $ClassifyGroupOptionId
 * @property int|null $ClassifyGroupId
 * @property int $ValueId
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Attributevalue $attributevalue
 * @property Classifygroup|null $classifygroup
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Classifygroupoption extends Model
{
	protected $table = 'classifygroupoption';
	protected $primaryKey = 'ClassifyGroupOptionId';
	public $timestamps = false;

	protected $casts = [
		'ClassifyGroupId' => 'int',
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
		'ClassifyGroupId',
		'ValueId',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function attributevalue()
	{
		return $this->belongsTo(Attributevalue::class, 'ValueId');
	}

	public function classifygroup()
	{
		return $this->belongsTo(Classifygroup::class, 'ClassifyGroupId');
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'Group2');
	}
}
