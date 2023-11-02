<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Vote;
use App\Models\Comment;
use Auth;

class Feedback extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'feedbacks';

    public const CAN_COMMENT_SELECT = [
        '0' => 'No',
        '1' => 'Yes',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'can_comment',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getTimeSinceCreation()
    {
        $currentTime = Carbon::now();
        $timeSinceCreation = $this->created_at->diffForHumans($currentTime);
        return str_replace("before", "ago", $timeSinceCreation);
    }

    public function getVotesCount(){
        return Vote::where('feedback_id', $this->id)->count();
    }

    public function getCommentsCount(){
        return Comment::where('feedback_id', $this->id)->count();
    }

    public function isUserVoted(){
        $user_id = Auth::user()->id;
        return Vote::where(['user_id' => $user_id, 'feedback_id' => $this->id])->exists();
    }
}
