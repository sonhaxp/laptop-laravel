<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * 
 * @property int $AttributeId
 * @property string $Name
 * @property string|null $DisplayName
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property Collection|Category[] $categories
 * @property Collection|Attributedetail[] $attributedetails
 * @property Collection|Attributevalue[] $attributevalues
 * @property Collection|Classifygroup[] $classifygroups
 *
 * @package App\Models
 */
class Attribute extends Model
{
	protected $table = 'attribute';
	protected $primaryKey = 'AttributeId';
	public $timestamps = false;

	protected $casts = [
		'Status' => 'int',
		'CreateBy' => 'int',
		'UpdateBy' => 'int'
	];

	protected $dates = [
		'CreateAt',
		'UpdateAt'
	];

	protected $fillable = [
		'Name',
		'DisplayName',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'attributecategory', 'AttributeId', 'CategoryId')
					->withPivot('AttributeCategoryId', 'Note', 'Status');
	}

	public function attributedetails()
	{
		return $this->hasMany(Attributedetail::class, 'AttributeId');
	}

	public function attributevalues()
	{
		return $this->hasMany(Attributevalue::class, 'AttributeId');
	}

	public function classifygroups()
	{
		return $this->hasMany(Classifygroup::class, 'AttributeId');
	}
}
