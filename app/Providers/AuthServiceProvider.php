<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Question::class =>QuestionPolicy::class,
        Answer::class =>AnswerPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate Method:-
        // Gate::define('update-question', function(User $user, Question $question){
        //     return $user->id === $question->user_id;
        // });

        // Gate::define('delete-question', function(User $user, Question $question){
        //     return $user->id === $question->user_id;
        // });

    }
}
