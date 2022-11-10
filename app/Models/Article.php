<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * 
 * @property int $ArticlesId
 * @property int $UserId
 * @property string $Subject
 * @property string $Description
 * @property string|null $Body
 * @property string|null $Image
 * @property Carbon $CreateDate
 * @property int $Status
 * @property int $ArticleCategoryId
 * @property string|null $Url
 * @property string|null $TitleMeta
 * @property string|null $DescriptionMeta
 * 
 * @property Articlecategory $articlecategory
 * @property User $user
 *
 * @package App\Models
 */
class Article extends Model
{
	protected $table = 'articles';
	protected $primaryKey = 'ArticlesId';
	public $timestamps = false;

	protected $casts = [
		'UserId' => 'int',
		'Status' => 'int',
		'ArticleCategoryId' => 'int'
	];

	protected $dates = [
		'CreateDate'
	];

	protected $fillable = [
		'UserId',
		'Subject',
		'Description',
		'Body',
		'Image',
		'CreateDate',
		'Status',
		'ArticleCategoryId',
		'Url',
		'TitleMeta',
		'DescriptionMeta'
	];

	public function articlecategory()
	{
		return $this->belongsTo(Articlecategory::class, 'ArticleCategoryId');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'UserId');
	}
}
