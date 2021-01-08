<?php

namespace ChatBot\Model;


class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=chatbot_db;charset=utf8', 'root', '');
        return $db;
    }
}