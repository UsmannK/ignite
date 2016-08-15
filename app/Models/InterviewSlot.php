<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InterviewSlot extends Model
{
	protected $table = 'interview_slot';
	protected $fillable = ['*'];
	public $timestamps = false;
}