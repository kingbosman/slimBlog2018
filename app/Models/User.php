<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class User extends Model {
	
	protected $table = 'users';

	protected $fillable = [
		'user_name',
		'user_email',
		'user_password',
		'user_active',
	];

	public function setpassword($password, $user_id) {

		$this->where('user_id', $user_id)->update([
			'user_password' => password_hash($password, PASSWORD_DEFAULT)
		]);
		
	}

}