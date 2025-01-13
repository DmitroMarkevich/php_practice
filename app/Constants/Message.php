<?php

namespace App\Constants;

class Message
{
    public const UserErrors = [
        'USER_EMAIL_IS_VERIFIED' => 'The user email has already been verified.',
        'USER_NOT_FOUND' => 'The user could not be found in the system. Please verify the provided information or try again later.',
        'USER_ALREADY_EXISTS' => 'A user with this email address already exists. Please use a different email.',
        'USER_ALREADY_VERIFIED' => 'The user account has already been verified. No further action is required.',
        'USER_ACCOUNT_INACTIVE' => 'The user account is inactive. Please verify your email or contact support.',
        'USER_CREDENTIALS_INVALID' => 'The provided credentials are invalid. Please verify your username and password.',
        'USER_INVALID_VERIFICATION_TOKEN' => 'The verification token is invalid, expired, or already used. Please request a new token.',
        'USER_ROLE_FORBIDDEN' => 'You do not have the required role to access this resource.'
    ];

    public const AuthErrors = [
        'TOKEN_EXPIRED' => 'The token provided has expired. Please request a new token and try again.',
        'TOKEN_INVALID' => 'The token provided is invalid. Ensure you are using a valid token and try again.',
        'UNAUTHORIZED_ACTION' => 'You do not have the necessary permissions to perform this action.'
    ];
}
