<?php

/* *********** Create Routes and Connect them with Controllers ***********
 * warning: put the most specific route to the top!
 * Don't forget about the namespaces!
 */

// ************** Example **************

/*
 * The Hello World example.
 * The /greeting example with execute the "greet"- Method of the GreetingController class,
 * which is located in the namespace Source\Controller
 */
$app->get("/greeting", '\Source\Controller\GreetingController:greet')->setName("greet");

// ************** Homepage - Routes **************

/*
 * The Welcome - Homepage
 */
$app->get("/home", '\Source\Controller\HomeController:index')->setName("home");


// ************** Registration - Routes **************

$app->get("/register/success", '\Source\Controller\RegistrationController:success')->setName("register.success");

/*
 * The Index - Page
 */
$app->get("/register",'\Source\Controller\RegistrationController:index')->setName("register");

/*
 * Register User
 */
$app->post("/register", '\Source\Controller\RegistrationController:register')->setName("register.post");

