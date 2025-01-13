<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\Custom\UserNotFoundException;

class UserService
{
    /**
     * Retrieve a user by their ID.
     *
     * @param int $id The user's ID.
     * @return User The retrieved user.
     * @throws UserNotFoundException If no user is found with the given ID.
     */
    public function getUserById(int $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * Retrieve a user by their email address.
     *
     * @param string $email The user's email address.
     * @return User The retrieved user.
     * @throws UserNotFoundException If no user is found with the given email address.
     */
    public function getUserByEmail(string $email): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * Check if a user already exists by their email address.
     *
     * @param string $email The email address to check.
     * @return bool True if a user with the given email exists, false otherwise.
     */
    public function isUserExistByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}
