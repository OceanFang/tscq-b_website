<?php

namespace App\Services;

use App\Repository\AuthRepository;

class AuthService
{
    protected $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    /**
     * 將資料庫取出的群組資料格式轉為陣列.
     *
     * @param array $groups 群組
     *
     * @return array 群組
     */
    public function getGroupArray($groups)
    {
        $results = [];
        foreach ($groups as $group) {
            $results[$group->id] = $group->name;
        }

        return $results;
    }

    public function saveUser($data)
    {
        return $this->authRepo->createUser($data);
    }
}
