<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attributecategory
 * 
 * @property int $AttributeCategoryId
 * @property int $CategoryId
 * @property int $AttributeId
 * @property string|null $Note
 * @property int $Status
 * 
 * @property Attribute $attribute
 * @property Category $category
 *
 * @package App\Models
 */
class Attributecategory extends Model
{
	protected $table = 'attributecategory';
	protected $primaryKey = 'AttributeCategoryId';
	public $timestamps = false;

	protected $casts = [
		'CategoryId' => 'int',
		'AttributeId' => 'int',
		'Status' => 'int'
	];

	protected $fillable = [
		'CategoryId',
		'AttributeId',
		'Note',
		'Status'
	];

	public function attribute()
	{
		return $this->belongsTo(Attribute::class, 'AttributeId');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'CategoryId');
	}
}
