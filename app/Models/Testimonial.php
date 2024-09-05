<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class Testimonial extends Model {
	
	protected $table = 'testimonials';

	protected $fillable = [
		'testimonial_content',
		'testimonial_author',
		'testimonial_active',
		'testimonial_image',
	];

	public function deleteSelectedTestimonial($id) {

		$this->where('testimonial_id', $id)->update([
			'testimonial_active' => 0,
		]);
		
	}

	public function updateSelectedTestimonial($id, $author, $content, $image) {

		$this->where('testimonial_id', $id)->update([
			'testimonial_author' => $author,
			'testimonial_content' => $content,
			'testimonial_image' => $image,
		]);
		
	}

}