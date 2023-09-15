<?php


namespace App\Repositories\Contracts;


use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryContract
{

    /**
     * @param int $user_id
     * @param array $with
     * @return User
     */
    public function getById(int $user_id, $rel = []): User;

    /**
     * @param array $user_ids
     * @param array $with
     * @return Collection|User[]
     */
    public function getUsersByIds(array $user_ids, array $with = []): Collection;

    /**
     * @param int $perPage
     * @param array $rel
     * @param string|null $role
     * @param string $sortDir
     * @return CursorPaginator
     */
    public function getUsers(int $perPage, array $rel = [], string $role = null, string $sortDir = 'desc'): CursorPaginator;

    /**
     * @param int $perPage
     * @param array $rel
     * @param string $sortDir
     * @return CursorPaginator
     */
    public function getDeletedUsers(int $perPage, array $rel = [], string $sortDir = 'desc'): CursorPaginator;
    
    /**
     * @param array $user_ids
     * @param array $with
     * @param int $perPage
     * @return CursorPaginator
     */
    public function paginateUsersByIds(array $user_ids, array $with = [], int $perPage = 12): CursorPaginator;

    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateUser(User $user, array $data): bool;

    /**
     * @param string $queryString
     * @param int $perPage
     * @return CursorPaginator
     */
    public function searchUsers(string $queryString, int $perPage = 12): CursorPaginator;
}
