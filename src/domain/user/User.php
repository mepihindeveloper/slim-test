<?php

declare(strict_types = 1);

namespace app\domain\user;

class User {

    private ?int $id;
    private string $name;
    private int $age;

    /**
     * User constructor.
     *
     * @param int|null $id
     * @param string   $name
     * @param int      $age
     */
    public function __construct(?int $id, string $name, int $age) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAge(): int {
        return $this->age;
    }
}