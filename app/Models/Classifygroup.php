<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classifygroup
 * 
 * @property int $ClassifyGroupId
 * @property int $AttributeId
 * @property int $ProductId
 * @property int|null $Stt
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Attribute $attribute
 * @property Product $product
 * @property Collection|Classifygroupoption[] $classifygroupoptions
 *
 * @package App\Models
 */
class Classifygroup extends Model
{
	protected $table = 'classifygroup';
	protected $primaryKey = 'ClassifyGroupId';
	public $timestamps = false;

	protected $casts = [
		'AttributeId' => 'int',
		'ProductId' => 'int',
		'Stt' => 'int',
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
		'Stt',
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

	public function product()
	{
		return $this->belongsTo(Product::class, 'ProductId', 'ProductID');
	}

	public function classifygroupoptions()
	{
		return $this->hasMany(Classifygroupoption::class, 'ClassifyGroupId');
	}
}
