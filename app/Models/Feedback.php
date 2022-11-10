<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * 
 * @property int $FeedBackId
 * @property int $UserId
 * @property string|null $Comment
 * @property int $Status
 * @property Carbon $CreateAt
 * @property Carbon|null $UpdateAt
 * @property int $CreateBy
 * @property int|null $UpdateBy
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Feedback extends Model
{
	protected $table = 'feedback';
	protected $primaryKey = 'FeedBackId';
	public $timestamps = false;

	protected $casts = [
		'UserId' => 'int',
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
		'Comment',
		'Status',
		'CreateAt',
		'UpdateAt',
		'CreateBy',
		'UpdateBy'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'UserId');
	}
}
