<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Возвращает список всех пользователей.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $users = $this->userService->getAll();

        return UserResource::collection($users);
    }

    /**
     * Возвращает данные конкретного пользователя.
     *
     * @param int $id
     * @return UserResource|JsonResponse
     */
    public function show(int $id): UserResource|JsonResponse
    {
        $user = $this->userService->getById($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    /**
     * Создаёт нового пользователя.
     *
     * @param Request $request
     * @return UserResource|JsonResponse
     */
    public function store(Request $request): UserResource|JsonResponse
    {
        $validator = UserRequest::validateCreate($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = $this->userService->create($request->all());

        return new UserResource($user);
    }

    /**
     * Обновляет данные пользователя.
     *
     * @param Request $request
     * @param int $id
     * @return UserResource|JsonResponse
     */
    public function update(Request $request, int $id): UserResource|JsonResponse
    {
        $validator = UserRequest::validateUpdate($request, $id);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = $this->userService->update($id, $request->all());

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    /**
     * Удаляет пользователя.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->userService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Проверка существования пользователя по ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function checkUserExists(int $id): JsonResponse
    {
        $userExists = $this->userService->userExists($id);

        if ($userExists) {
            return response()->json(['message' => 'User exists', 'exists' => true]);
        } else {
            return response()->json(['message' => 'User not found', 'exists' => false], 404);
        }
    }
}
