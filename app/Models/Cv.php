<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class Cv extends Model {

	protected $table = 'cvs';

	protected $fillable = [
		'cv_url',
		'cv_active',
	];

}