<?php

namespace App\Model;

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

class Token {
    
    private string $value;
    
    function __construct(int $limit = 10) {
        $this->setValue($this->generateRandomString($limit));
    }

    public function generateRandomString(int $length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters); $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    function getValue(): string {
        return $this->value;
    }

    function setValue(string $value): void {
        $this->value = $value;
    }
    
}