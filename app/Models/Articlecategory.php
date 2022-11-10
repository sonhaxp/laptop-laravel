<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Articlecategory
 * 
 * @property int $ArticleCategoriesId
 * @property string $CategoryName
 * @property string|null $Url
 * @property int $CategorySort
 * @property bool $Status
 * @property int|null $ArticleCategoriesParentId
 * @property string|null $Image
 * 
 * @property Articlecategory|null $articlecategory
 * @property Collection|Articlecategory[] $articlecategories
 * @property Collection|Article[] $articles
 *
 * @package App\Models
 */
class Articlecategory extends Model
{
	protected $table = 'articlecategories';
	protected $primaryKey = 'ArticleCategoriesId';
	public $timestamps = false;

	protected $casts = [
		'CategorySort' => 'int',
		'Status' => 'bool',
		'ArticleCategoriesParentId' => 'int'
	];

	protected $fillable = [
		'CategoryName',
		'Url',
		'CategorySort',
		'Status',
		'ArticleCategoriesParentId',
		'Image'
	];

	public function articlecategory()
	{
		return $this->belongsTo(Articlecategory::class, 'ArticleCategoriesParentId');
	}

	public function articlecategories()
	{
		return $this->hasMany(Articlecategory::class, 'ArticleCategoriesParentId');
	}

	public function articles()
	{
		return $this->hasMany(Article::class, 'ArticleCategoryId');
	}
}
