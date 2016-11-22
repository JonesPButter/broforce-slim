<?php

/* *********** Create Routes and Connect them with Controllers ***********
 * warning: put the most specific route to the top!
 * Don't forget about the namespaces!
 */

/*
 * The Hello World example.
 * The /greeting example with execute the "greet"- Method of the GreetingController class,
 * which is located in the namespace Source\Controller
 */
$app->get("/greeting", '\Source\Controller\GreetingController:greet')->setName("greet");


$app->get("/home", '\Source\Controller\HomeController:index')->setName("home");

/*
 * The extended Hello-World example, featuring Views.
 */
// Um die route wieder verwenden zu können muss slim/php-view wieder required werden
$app->get('/[{name}]', '\Source\Controller\GreetingController:greetWithName');

