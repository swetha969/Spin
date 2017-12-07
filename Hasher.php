<?php

class Hasher
{
    public function hash($to_hash, $salt)
    {
        return password_hash($to_hash, PASSWORD_DEFAULT, ['salt' => $salt]);
    }
}
