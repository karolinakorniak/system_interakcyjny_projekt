<?php

namespace App\Repository;

class CategoriesRepository
{
    private array $data = [
        [
            'id' => 1,
            'name' => "Kategoria 1",
            'slug' => "kategoria_1"
        ],
        [
            'id' => 2,
            'name' => "Kategoria 2",
            'slug' => "kategoria_2"
        ],
        [
            'id' => 3,
            'name' => "Kategoria 3",
            'slug' => "kategoria_3"
        ]
    ];

    public function findAll() {
        return $this->data;
    }
}