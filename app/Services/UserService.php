<?php

namespace App\Services;

use App\Models\User;
use App\Enums\EmailType;
use App\Jobs\SendEmailJob;
use App\Exceptions\UserAlreadyExistsException;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    /**
     * Store a new user in the database.
     *
     * This method ensures that no user with the same email already exists.
     * If a user with the provided email exists, a UserAlreadyExistsException is thrown.
     *
     * @param User $user The user instance to be stored.
     * @return void
     * @throws UserAlreadyExistsException If a user with the same email already exists.
     */
    public function storeUser(User $user): void
    {
        $userEmail = $user->email;

        DB::transaction(function () use ($user, $userEmail) {
            $existingUser = User::where('email', $userEmail)->first();

            if ($existingUser) {
                throw new UserAlreadyExistsException("User with email $userEmail already exists");
            }

            $user->save();

            SendEmailJob::dispatch(EmailType::PASSWORD_RESET, [], $user->email);
        });
    }
}
