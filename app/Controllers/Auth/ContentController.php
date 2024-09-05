<?php 

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Category;
use App\Models\Slide;
use App\Models\Testimonial;
use App\Models\Cv;
use Respect\Validation\Validator as v;

Use Slim\Views\Twig as View;

class ContentController extends Controller { 

	public function getOtherContent($request, $response) {

		return $this->view->render($response, 'auth/admin/content/other.twig');

	}

	public function addCategory($request, $response) {

		$validation = $this->validator->validate($request, [
			'name' => v::notEmpty()->length(null, 255)->categoryAvailable(),
		]);

		if ($validation->failed()) {

			$this->flash->addMessage('danger', 'oops! Looks like something went terrible wrong...');

			return $response->withRedirect($this->router->pathFor('admin.content.other'));

		}

		$category = Category::create([
			'category_name' => $request->getParam('name'),
		]);

		$this->flash->addMessage('success', 'Category added!');

		return $response->withRedirect($this->router->pathFor('admin.content.other'));
		
	}

	public function getHomeContent($request, $response) {

		return $this->view->render($response, 'auth/admin/content/home.twig', [
			'slides' => Slide::where('slide_active', '1')->get(),
			'testimonials' => Testimonial::where('testimonial_active', '1')->get(),
		]);
		
	}

	public function addSlide($request, $response) {

		$validation = $this->validator->validate($request, [
			'intro' => v::notEmpty()->length(null, 150),
			'slide_content' => v::notEmpty()->length(null, 255),
		]);

		if ($validation->failed()) {

			$this->flash->addMessage('danger', 'oops! Looks like something went terrible wrong...');

			return $response->withRedirect($this->router->pathFor('admin.content.home'));

		}

		$slide = Slide::create([
			'slide_intro' => $request->getParam('intro'),
			'slide_content' => $request->getParam('slide_content'),
			'slide_image' => $request->getParam('slide_image'),
		]);

		$this->flash->addMessage('success', 'Slide added!');

		return $response->withRedirect($this->router->pathFor('admin.content.home'));
		
	}

	public function addCv($request, $response) {

		$validation = $this->validator->validate($request, [
			'cv_file' => v::notEmpty(),
		]);

		if ($validation->failed()) {

			$this->flash->addMessage('danger', 'oops! Looks like something went terrible wrong...');

			return $response->withRedirect($this->router->pathFor('admin.content.home'));

		}

		$slide = Cv::create([
			'cv_url' => $request->getParam('cv_file'),
			'cv_active' => 1,
		]);

		$this->flash->addMessage('success', 'Cv added!');

		return $response->withRedirect($this->router->pathFor('admin.content.other'));
		
	}

	public function addTestimonial($request, $response) {

		$validation = $this->validator->validate($request, [
			'author' => v::notEmpty()->length(null, 100),
			'testimonial_content' => v::notEmpty()->length(null, 255),
		]);

		if ($validation->failed()) {

			$this->flash->addMessage('danger', 'oops! Looks like something went terrible wrong...');

			return $response->withRedirect($this->router->pathFor('admin.content.home'));

		}

		$testimonial = Testimonial::create([
			'testimonial_author' => $request->getParam('author'),
			'testimonial_content' => $request->getParam('testimonial_content'),
			'testimonial_image' => $request->getParam('testimonial_image'),
		]);

		$this->flash->addMessage('success', 'Testimonial added!');

		return $response->withRedirect($this->router->pathFor('admin.content.home'));
		
	}

	public function getSlideContent($request, $response, $id) {

		return $this->view->render($response, 'auth/admin/content/slide.twig', [
			'slide' => Slide::where('slide_id', $id['id'])->first(),
		]);
		
	}

	public function deleteSlideContent($request, $response, $id) {

		$this->auth->slide($id['id'])->deleteSelectedSlide($id['id']);

		$this->flash->addMessage('warning', 'The selected slide has been removed');

		return $response->withredirect($this->router->pathFor('admin.content.home'));
		
	}

	public function updateSlideContent($request, $response, $id) {

		$this->auth->slide($id['id'])->updateSelectedSlide(
			$id['id'], 
			$request->getParam('intro'), 
			$request->getParam('slide_content'),
			$request->getParam('image')
		);

		$this->flash->addMessage('success', 'The selected slide is updated');

		return $response->withredirect($this->router->pathFor('admin.content.home'));
		
	}

	public function getTestimonialContent($request, $response, $id) {

		return $this->view->render($response, 'auth/admin/content/testimonial.twig', [
			'testimonial' => Testimonial::where('testimonial_id', $id['id'])->first(),
		]);
		
	}

	public function deleteTestimonialContent($request, $response, $id) {

		$this->auth->testimonial($id['id'])->deleteSelectedTestimonial($id['id']);

		$this->flash->addMessage('warning', 'The selected testimonial has been removed');

		return $response->withredirect($this->router->pathFor('admin.content.home'));
		
	}

	public function updateTestimonialContent($request, $response, $id) {

		$this->auth->testimonial($id['id'])->updateSelectedTestimonial(
			$id['id'], 
			$request->getParam('author'), 
			$request->getParam('testimonial_content'),
			$request->getParam('image')
		);

		$this->flash->addMessage('success', 'The selected testimonial is updated');

		return $response->withredirect($this->router->pathFor('admin.content.home'));
		
	}

}