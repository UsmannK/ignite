<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InterviewSlot extends Model
{
	protected $table = 'interview_slot';
	protected $fillable = ['*'];
	public $timestamps = false;
	protected $appends = ['applications'];
	public function getApplicationsAttribute() {
		$apps = Application::where('interview_timeslot',$this->id)->get(array('name'));
		$string = "";
		foreach($apps as $app) {
			$string .= $app['name'] . ", ";
		}
		return rtrim($string, ', ');
	}
}