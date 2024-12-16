<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Exceptions\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $perPage = 15)
    {
        //
    }

    /**
     * Handle the request to store a new user resource.
     *
     * @param UserRequest $request The validated user request containing input data.
     * @return Response A response indicating the resource was created.
     * @throws UserAlreadyExistsException If a user with the same unique data already exists.
     */
    public function store(UserRequest $request): Response
    {
        $validated = $request->validated();

        $this->userService->storeUser(new User($validated));

        return response()->noContent(ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
