<?php

/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 21.11.2016
 * Time: 10:50
 */
namespace Source\Models;
use Illuminate\Database\Eloquent\Model;

/*
 * The User Class is already connected with the "users"-Table in the Database
 */
class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'name',
        'familyname',
        'password'
    ];

}