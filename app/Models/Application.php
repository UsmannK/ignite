<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Application extends Model {
	protected $fillable = array('uuid', 'name');

	public function ratingInfo()
    {
        $count = ApplicationRating::where('application_id',$this->id)->get()->count();
        $sum = 0;
        $ratings=[];
        foreach ($this->ratings as $each) {
            $rating=intval($each->rating);
            $sum+=$rating;
            $ratings[]=$rating;
        }
        $min=0; $max=0; $avg=0;
            if($count!=0)
            {
                $avg = $sum/$count;
                $min = min($ratings);
                $max = max($ratings);
                $avg = $sum/$count;
            }
        return 
        [
            "count"=>$count,
            "min"=>$min,
            "max"=>$max,
            // "ratings"=>$ratings,
            "average"=>$avg
        ];
    }
	protected $appends = ['reviews', 'UserRating'];
	/**
    * Determine number of times the application has been reviewed
    */
    public function getReviewsAttribute() {
        return ApplicationRating::where('application_id',$this->id)->get()->count();
    }
    public function getUserRatingAttribute() {
        $rating = ApplicationRating::where('application_id',$this->id)->where('user_id', Auth::user()->id)->first();
        if($rating) {
            return $rating->rating;
        }
        return "Not rated";
    }
    public function ratings() {
        return $this->hasMany('App\Models\ApplicationRating');
    }
    public function userRating() {
        $rating = ApplicationRating::where('application_id',$this->id)->where('user_id', Auth::user()->id)->first();
        if($rating) {
            return $rating->rating;
        }
        return "Not rated";
    }
}