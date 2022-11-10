<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider
 * 
 * @property int $Id
 * @property string $BannerName
 * @property string|null $Slogan
 * @property string|null $Image
 * @property bool $Status
 * @property string|null $Url
 * @property int $Sort
 * @property string|null $BtnText
 *
 * @package App\Models
 */
class Slider extends Model
{
	protected $table = 'slider';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'Status' => 'bool',
		'Sort' => 'int'
	];

	protected $fillable = [
		'BannerName',
		'Slogan',
		'Image',
		'Status',
		'Url',
		'Sort',
		'BtnText'
	];
}
