<?php


namespace App\Traits\Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;

trait ActsAsUsers
{
    /**
     * @param User|Model $user
     * @param array $abilities
     */
    private function actingAsUser(User $user, array $abilities = []):void
    {
        Sanctum::actingAs($user, $abilities);
    }

    /**
     * @return Model|User
     */
    private function actingAsAdmin(): User
    {
        $user = User::factory(['is_admin' => true])->create();
        $this->actingAsUser($user);

        return $user;
    }
}
