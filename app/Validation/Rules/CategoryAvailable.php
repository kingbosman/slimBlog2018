<?php 

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\Category;

class CategoryAvailable extends AbstractRule {

	public function validate($input) {

		return Category::where('category_name', $input)->count() === 0;
		
	}
		
}