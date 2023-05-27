<?php

namespace App\Repository;

class AuthorsRepository
{
    private array $data = [
        [
            'id' => 1,
            'name' => "Imie 1",
        ],
        [
            'id' => 2,
            'name' => "Imie 2",
        ],
        [
            'id' => 3,
            'name' => "Imie 3",

        ]
    ];

    public function findAll() {
        return $this->data;
    }
}