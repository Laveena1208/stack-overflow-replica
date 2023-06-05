<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute()
    {
        $rounded = true;
        $name = $this->name;
        $size = 40;
        return "https://ui-avatars.com/api/?name={$name}&rounded={$rounded}&size={$size}";

    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class);
    }

    public function votesQuestion()
    {
        return $this->morphedByMany(Question ::class, 'vote')->withTimestamps();
    }

    public function votesAnswer()
    {
        return $this->morphedByMany(Answer ::class, 'vote')->withTimestamps();
    }

    public function hasQuestionUpVoted(Question $question)
    {
        return $this->votesQuestion()->where(['vote_id'=>$question->id, 'vote'=>1])->exists();
    }

    public function hasQuestionDownVoted(Question $question)
    {
        return $this->votesQuestion()->where(['vote_id'=>$question->id, 'vote'=>-1])->exists();
    }

    public function hasVoteForQuestion(Question $question)
    {
        return $this->hasQuestionUpVoted($question) || $this->hasQuestionDownVoted($question);
    }

    //answer
    public function hasAnswerUpVoted(Answer $answer)
    {
        return $this->votesAnswer()->where(['vote_id'=>$answer->id, 'vote'=>1])->exists();
    }

    public function hasAnswerDownVoted(Answer $answer)
    {
        return $this->votesQuestion()->where(['vote_id'=>$answer->id, 'vote'=>-1])->exists();
    }

    public function hasVoteForAnswer(Answer $answer)
    {
        return $this->hasAnswerUpVoted($answer) || $this->hasAnswerDownVoted($answer);
    }
}
