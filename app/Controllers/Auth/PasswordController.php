<?php 

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class PasswordController extends Controller { 

	public function getChangePassword($request, $response) {

		return $this->view->render($response, 'auth/password/change.twig');
		
	}

	public function postChangePassword($request, $response) {

		$validation = $this->validator->validate($request, [
			'password' => v::noWhiteSpace()->notEmpty()->matchesPassword($this->auth->user()->user_password),
			'new_password' => v::noWhiteSpace()->notEmpty(),
			'repeat_new_password' => v::noWhiteSpace()->notEmpty(),
		]);

		if ($validation->failed()) {

			return $response->withRedirect($this->router->pathFor('auth.password.change'));

		}

		if ($request->getParam('new_password') != $request->getParam('repeat_new_password')) {

			$this->flash->addMessage('danger', 'Passwords do not match...');
			return $response->withRedirect($this->router->pathFor('auth.password.change'));

		}

		$this->auth->user()->setPassword($request->getParam('new_password'), $this->auth->user()->user_id);

		$this->flash->addMessage('success', 'Your password has been changed');
		return $response->withRedirect($this->router->pathFor('auth.password.change'));
		
	}

}