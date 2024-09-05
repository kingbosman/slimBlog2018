<?php 

namespace App\Auth;

use App\Models\User;
use App\Models\Article;
use App\Models\Slide;
use App\Models\Testimonial;

class Auth {

	public function user() {

		if (isset($_SESSION['user'])) {

			return User::where('user_id', $_SESSION['user'])->first();

		}
		
	}

	public function article($id) {

		if (isset($id)) {

			return Article::where('article_id', $id)->first();

		}
		
	}

	public function slide($id) {

		if (isset($id)) {

			return Slide::where('slide_id', $id)->first();

		}
		
	}

	public function testimonial($id) {

		if (isset($id)) {

			return Testimonial::where('testimonial_id', $id)->first();

		}
		
	}

	public function check() {

		return isset($_SESSION['user']);
		
	}

	public function attempt($name, $password) {

		$user = User::where('user_name', $name)->first();

		if (!$user) {

			return false;

		}

		if (password_verify($password, $user->user_password)) {

			$_SESSION['user'] = $user->user_id;
			return true;
		}

		return false;
		
	}

	public function logOut() {

		unset($_SESSION['user']);
		
	}
		
}