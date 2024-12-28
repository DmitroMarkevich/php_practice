<?php

namespace App\Services;

use App\Enums\EmailType;
use App\Exceptions\Custom\UserAlreadyExistsException;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Store a new user in the database.
     *
     * @param User $user The user instance to be stored.
     * @return void This method performs a database transaction and sends an email but does not return any value.
     * @throws UserAlreadyExistsException If a user with the same email already exists.
     */
    public function storeUser(User $user): void
    {
        $userEmail = $user->email;

        DB::transaction(function () use ($user, $userEmail) {
            $existingUser = User::where('email', $userEmail)->first();

            if ($existingUser) {
                throw new UserAlreadyExistsException("User with email `$userEmail` already exists");
            }

            $user->save();

            SendEmailJob::dispatch(EmailType::PASSWORD_RESET, [], $user->email);
        });
    }
}
