<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class Download extends Model {
	
	protected $table = 'downloads';

	protected $fillable = [
		'download_file',
		'download_ip',
		'download_browser'
	];

}