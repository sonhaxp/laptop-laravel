<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Configsite
 * 
 * @property int $ConfigSiteId
 * @property string|null $Facebook
 * @property string|null $Linkedin
 * @property string|null $Instagram
 * @property string|null $Twitter
 * @property string|null $LiveChat
 * @property string|null $Image
 * @property string|null $GoogleMap
 * @property string|null $GoogleAnalytics
 * @property string|null $Place
 * @property string|null $VPDD
 * @property string|null $Title
 * @property string|null $Description
 * @property string|null $Hotline
 * @property string|null $Email
 * @property string|null $Youtube
 * @property string|null $EmailContact
 * @property string|null $EmailEInvoice
 * @property string|null $Name
 *
 * @package App\Models
 */
class Configsite extends Model
{
	protected $table = 'configsite';
	protected $primaryKey = 'ConfigSiteId';
	public $timestamps = false;

	protected $fillable = [
		'Facebook',
		'Linkedin',
		'Instagram',
		'Twitter',
		'LiveChat',
		'Image',
		'GoogleMap',
		'GoogleAnalytics',
		'Place',
		'VPDD',
		'Title',
		'Description',
		'Hotline',
		'Email',
		'Youtube',
		'EmailContact',
		'EmailEInvoice',
		'Name'
	];
}
