<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 * 
 * identificar al visitante
 * para poder acceder al panel admin
 */

namespace App\Model;

class User {

    private string $login;
    private string $password;
    private string $email;
    private bool $admin;

    public function getLogin(): string {
        return $this->login;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function isAdmin(): bool {
        return $this->admin;
    }

    public function setLogin(string $login): void {
        $this->login = $login;
    }
    public function setPassword(string $password): void {
        $this->password = $password;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function setAdmin(bool $admin): void {
        $this->admin = $admin;
    }

}