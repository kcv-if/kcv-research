<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidAuthor implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        // TODO: move this to business layer
        $emails = array_unique(explode(' ', $value));
        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $fail('All authors must be registered first.');
            } else if ($user->role === 'a') {
                $fail('No author is an admin.');
            }
        }
    }
}
