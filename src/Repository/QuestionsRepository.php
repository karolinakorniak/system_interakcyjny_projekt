<?php

namespace App\Repository;

class QuestionsRepository
{
    private array $data = [
        [
            'id' => 1,
            'title' => "Pytanie 1?",
            'slug' => "pytanie_1?"
        ],
        [
            'id' => 2,
            'title' => "Pytanie 2?",
            'slug' => "pytanie_2?"
        ],
        [
            'id' => 3,
            'title' => "Pytanie 3?",
            'slug' => "pytanie_3?"
        ]
    ];

    public function findAll() {
        return $this->data;
    }
}