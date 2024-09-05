<?php 

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

class NameAvailable extends AbstractRule {

	public function validate($input) {

		return User::where('user_name', $input)->count() === 0;
		
	}
		
}