<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckOldPassword implements Rule
{
    protected $userPassword;

    /**
     * Create a new rule instance.
     *
     * @param string $userPass
     */
    public function __construct($userPass)
    {
        $this->userPassword = $userPass;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->userPassword);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The old password is wrong, try one more time.';
    }
}
