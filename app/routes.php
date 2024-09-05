<?php 

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');
$app->get('/blog', 'BlogController:showPosts')->setName('blog');
$app->get('/blog/{name}', 'BlogController:showPostsFiltered')->setName('blog-filter');
$app->get('/blog/article/{id}/{name}', 'BlogController:showArticle')->setName('article');
$app->get('/cv', 'HomeController:downloadCv')->setName('cv');

$app->group('', function () {

	$this->get('/admin', 'AuthController:getSignIn')->setName('auth.signin');
	$this->post('/admin', 'AuthController:postSignIn');

})->add(new GuestMiddleware($container));

$app->group('', function () {

	$this->get('/admin/signout', 'AuthController:getSignOut')->setName('auth.signout');

	$this->get('/admin/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
	$this->post('/admin/password/change', 'PasswordController:postChangePassword');

	$this->get('/admin/signup', 'AuthController:getSignUp')->setName('auth.signup');
	$this->post('/admin/signup', 'AuthController:postSignUp');

	$this->get('/admin/home', 'AdminController:index')->setName('admin.home');

	$this->get('/admin/blog/add', 'BlogController:getBlogAdd')->setName('admin.blog.add');
	$this->post('/admin/blog/add', 'BlogController:postBlogAdd');

	$this->get('/admin/blog/content', 'BlogController:getBlogContent')->setName('admin.blog.content');

	$this->get('/admin/blog/article/{id}', 'BlogController:getBlogArticle');
	$this->post('/admin/blog/article/update/{id}', 'BlogController:updateArticle');
	$this->post('/admin/blog/article/delete/{id}', 'BlogController:deleteArticle');

	$this->get('/admin/content/other', 'ContentController:getOtherContent')->setName('admin.content.other');
	$this->post('/admin/content/other/category', 'ContentController:addCategory')->setName('admin.content.other.category');
	$this->post('/admin/content/other/cv', 'ContentController:addCv')->setName('admin.content.other.cv');
	
	$this->get('/admin/content/home', 'ContentController:getHomeContent')->setName('admin.content.home');
	
	$this->get('/admin/content/slide/{id}', 'ContentController:getSlideContent');
	$this->post('/admin/content/slide/add', 'ContentController:addSlide')->setName('admin.content.slide.add');
	$this->post('/admin/content/slide/update/{id}', 'ContentController:updateSlideContent');
	$this->post('/admin/content/slide/delete/{id}', 'ContentController:deleteSlideContent');

	$this->get('/admin/content/testimonial/{id}', 'ContentController:getTestimonialContent');
	$this->post('/admin/content/testimonial/add', 'ContentController:addTestimonial')->setName('admin.content.testimonial.add');
	$this->post('/admin/content/testimonial/update/{id}', 'ContentController:updateTestimonialContent');
	$this->post('/admin/content/testimonial/delete/{id}', 'ContentController:deleteTestimonialContent');

})->add(new AuthMiddleware($container));