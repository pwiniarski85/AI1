<?php

namespace App\Model;
use App\Service\Config;

class User
{
    private ?int $id=null;
    private ?string $name=null;
    private ?string $email=null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;

        return $this;
    }


    public static function fromArray($array): User
    {
        $user = new self();
        $user->fill($array);

        return $user;
    }

    public function fill($array): User
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['email'])) {
            $this->setEmail($array['email']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM user';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $users = [];
        $usersArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($usersArray as $userArray) {
            $users[] = self::fromArray($userArray);
        }

        return $users;
    }

    public static function find($id): ?User
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM user WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $userArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $userArray) {
            return null;
        }
        $user = User::fromArray($userArray);

        return $user;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO user (name, email) VALUES (:name, :email)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'name' => $this->getName(),
                'email' => $this->getEmail(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE user SET name = :name, email = :email WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':name' => $this->getName(),
                ':email' => $this->getEmail(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM user WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setName(null);
        $this->setEmail(null);
    }

}