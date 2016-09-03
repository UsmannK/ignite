<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InterviewAssignment extends Model {
	protected $fillable = ['*'];
	protected $table="interview_assignment";

	protected $appends = ['mentor'];
	public function getMentorAttribute() {
		$user = User::where('id',$this->user_id)->first(array('id', 'name'));
		return $user;
	}
}