<?php

/* *********** Create Routes and Connect them with Controllers ***********
 * warning: put the most specific route to the top!
 * Don't forget about the namespaces!
 */

// **************************** ROUTES ****************************

// ************** Example - Route **************

/*
 * The Hello World example.
 * The /greeting example with execute the "greet"- Method of the GreetingController class,
 * which is located in the namespace Source\Controller
 */
$app->get("/greeting", '\Source\Controller\GreetingController:greet')->setName("greet");

// ************** Homepage - Routes **************

// Get the Homepage
$app->get("/home", '\Source\Controller\HomeController:index')->setName("home");

// Redirect to Homepage
$app->get("/", function($request, $response) use ($container){
   return  $response->withRedirect($container->router->pathFor('home'));
});

// ************** Registration - Routes **************
// Get the registration success page
$app->get("/registration/success", '\Source\Controller\RegistrationController:success')->setName("register.success");
//Get the registration page
$app->get("/registration", '\Source\Controller\RegistrationController:getRegistration')->setName("register");
// post the user input
$app->post("/registration", '\Source\Controller\RegistrationController:postRegistration')->setName("register.post");


// ************** Login/Logout - Routes **************
// Get the Login page
$app->get("/authentication/login",'\Source\Controller\AuthController:index')->setName("logUserIn");
// Post the userinput
$app->post("/authentication/login",'\Source\Controller\AuthController:login')->setName("logUserIn.post");
// Log the the user out
$app->get("/authentication/logout",'\Source\Controller\AuthController:logout')->setName("logUserOut");


// ************** Change Password - Routes **************
// Get the change password page
$app->get("/userservice/change/password", '\Source\Controller\ChangePasswordController:getForm')->setName("changePW");
$app->post("/userservice/change/password", '\Source\Controller\ChangePasswordController:changePassword')->setName("changePW.post");