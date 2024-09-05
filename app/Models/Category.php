<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class Category extends Model {
	
	protected $table = 'categories';

	protected $fillable = [
		'category_name',
	];

}