<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;

class Question extends Model
{
  protected $fillable = ['title', 'body'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = $value;
    $this->attributes['slug'] = str_slug($value);
  }

  public function getUrlAttribute() {
    return route("questions.show", $this->slug);
  }

  public function getCreatedDateAttribute() {
    return $this->created_at->diffForHumans();
  }

  public function getStatusAttribute() {
    if($this->answers > 0) {
      if($this->best_answer_id > 0) {
        return "answerd-accepted";
      }
      return "answerd";
    }
    return "unanswerd";
  }

  public function getBodyHtmlAttribute() {
    return \Parsedown::instance()->text($this->body);
  }

  public function answersMethodRelationship() {
    return $this->hasMany(Answer::class);
  }

  // get value from column answers in db
  // column answers : câu hỏi đó có bao nhiêu câu trả lời
  public function getAnswersCountAttribute() {
    return $this->answers;
  }

  public function updateBestAnswer(Answer $answer) {
    $this->best_answer_id = $answer->id;
    $this->save();
  }

  public function votes() {
    return $this->morphToMany(User::class, 'votable');
  }
}
