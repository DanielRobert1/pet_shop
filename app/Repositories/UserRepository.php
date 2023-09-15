<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Recca0120\Repository\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryContract
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param string $email
     * @return ?User
     */
    final public function getByEmail(string $email): ?User
    {
        return $this->newQuery()
            ->where('email', $email)->first();
    }

    /**
     * @param int $user_id
     * @param array $with
     * @return User
     */
    final public function getById(int $user_id, $rel = []): User
    {

        return $this->newQuery()->with($rel)->find($user_id);
    }

    /**
     * @param array $user_ids
     * @param array $with
     * @return Collection|User[]
     */
    final public function getUsersByIds(array $user_ids, array $with = []): Collection
    {
        return $this->newQuery()->whereIn('id', $user_ids)->with($with)->get();
    }

    /**
     * @param array $user_ids
     * @param array $with
     * @param int $perPage
     * @return CursorPaginator
     */
    final public function paginateUsersByIds(array $user_ids, array $with = [], int $perPage = 12): CursorPaginator
    {
        return $this->newQuery()
            ->whereIn('id', $user_ids)
            ->with($with)->orderBy('created_at')
            ->cursorPaginate($perPage);
    }

    /**
     * @param int $perPage
     * @param array $rel
     * @param string|null $role
     * @param string $sortDir
     * @return CursorPaginator
     */
    final public function getUsers(int $perPage, array $rel = [], string $role = null, string $sortDir = 'desc'): CursorPaginator
    {
        $query = $this->newQuery();

        if($role) $query = $query->where('role', $role);

        return $query->with($rel)
            ->orderBy('id', $sortDir)
            ->cursorPaginate($perPage);
    }

    /**
     * @param int $perPage
     * @param array $rel
     * @param string $sortDir
     * @return CursorPaginator
     */
    final public function getDeletedUsers(int $perPage, array $rel = [], string $sortDir = 'desc'): CursorPaginator
    {
        return User::onlyTrashed()->with($rel)
            ->orderBy('id', $sortDir)
            ->cursorPaginate($perPage);
    }

    /**
     * @param array $data
     * @return User
     */
    final public function createUser(array $data): User
    {
        return $this->create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    final public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * @param string $queryString
     * @param int $perPage
     * @return CursorPaginator
     */
    final public function searchUsers(string $queryString, int $perPage = 12): CursorPaginator
    {
        $queryArray = explode(' ', $queryString);
        if( !in_array($queryString, $queryArray) ) $queryArray[] = $queryString;

        return $this->newQuery()
            ->where(function(Builder $builder) use ($queryArray){

                foreach ($queryArray as $item) {
                    $builder->orWhere('first_name', 'like', '%'.$item.'%')
                        ->orWhere('last_name', 'like', '%'.$item.'%')
                        ->orWhere('phone_number', 'like', '%'.$item.'%')
                        ->orWhere('email', 'like', '%'.$item.'%');
                }

            })->orderBy('created_at')->cursorPaginate($perPage);
    }
}
