<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // viết 1 cái cổng để gọi để phân quyền
      // nếu không phải thằng user đang login thì sẽ không xử lý cái question không phải của nó
      // chính nó mới cho phép sửa của chính nó, không cho phép sửa của người khác
      Gate::define("update-question", function($user, $question) {
        return $user->id == $question->user_id;
      });

      Gate::define("delete-question", function($user, $question) {
        return $user->id == $question->user_id;
      });
    }
}
