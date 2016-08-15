<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InterviewSlot extends Model
{
	protected $table = 'interview_slot';
	protected $fillable = ['*'];
	public $timestamps = false;
	protected $appends = ['applications', 'formattedStartTime', 'formattedEndTime'];
	public function getApplicationsAttribute() {
		$apps = Application::where('interview_timeslot',$this->id)->get(array('name'));
		$string = "";
		foreach($apps as $app) {
			$string .= $app['name'] . ", ";
		}
		return rtrim($string, ', ');
	}
	public function getFormattedStartTimeAttribute() {
		$c = new \Carbon\Carbon($this->start_time);
		return $c->format('l, F j \a\t g:i A');
	}
	public function getFormattedEndTimeAttribute() {
		$c = new \Carbon\Carbon($this->end_time);
		return $c->format('l, F j \a\t g:i A');
	}
}