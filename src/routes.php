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
$app->get("/greeting", '\Source\Controller\GreetingController:greet');

/*
 * The extended Hello-World example, featuring Views.
 */
$app->get('/[{name}]', '\Source\Controller\GreetingController:greetWithName');
