<?php

/* *********** Create Routes and Connect them with Controllers ***********
 * warning: put the most specific route to the top!
 * Don't forget about the namespaces!
 */
use \Source\Middleware\AdminMiddleware;
use \Source\Middleware\AuthorizedMiddleware;

// **************************** ROUTES ****************************

// public Routes
$app->group("", function () {
    // ************** Homepage - Routes **************
    // Get the Homepage
    $this->get("/home", '\Source\Controller\HomeController:index')->setName("home");

    $container = $this->getContainer();
    // Redirect to Homepage
    $this->get("/", function ($request, $response) use ($container) {
        return $response->withRedirect($container->router->pathFor('home'));
    });

    // ************** Login/Logout - Routes **************
    // Get the Login page
    $this->get("/authentication/login", '\Source\Controller\AuthController:index')->setName("logUserIn");
    // Post the userinput
    $this->post("/authentication/login", '\Source\Controller\AuthController:login')->setName("logUserIn.post");
    // Log the the user out
    $this->get("/authentication/logout", '\Source\Controller\AuthController:logout')->setName("logUserOut");
    // verify link
    $this->get("/authentication/{userid}/{token}", '\Source\Controller\AuthController:verify')->setName("verify");

    $this->get("/authentification/passwordRequest", '\Source\Controller\PasswordRequestController:getForm')->setName("passwordRequest");
    $this->post("/authentification/passwordRequest", '\Source\Controller\PasswordRequestController:sendPassword')->setName("passwordRequest.post");
    $this->get("/authentification/passwordRequest/newPW/{pw}", '\Source\Controller\PasswordRequestController:showNewPW')->setName("showNewPW");
});


// authorized Routes
$app->group("", function () {

    $container = $this->getContainer();
    // ************** Change User Data - Routes **************
    // Get the change password page
    $this->get("/userservice/change/password/{id}", '\Source\Controller\ChangePasswordController:getForm')->setName("changePW");
    $this->post("/userservice/change/password/{id}", '\Source\Controller\ChangePasswordController:changePassword')->setName("changePW.post");
    $this->get("/userservice/change/userdata/{id}", '\Source\Controller\ChangeUserDataController:getForm')->setName("changeData");
    $this->post("/userservice/change/userdata/{id}", '\Source\Controller\ChangeUserDataController:changeData')->setName("changeData.post");

    // admin - routes
    $this->group("", function(){
        // ************** Registration - Routes **************
        //Get the registration page
        $this->get("/registration", '\Source\Controller\RegistrationController:getRegistration')->setName("register");
        // post the user input
        $this->post("/registration", '\Source\Controller\RegistrationController:postRegistration')->setName("register.post");
        $this->get("/adminservice/change/password/{id}", '\Source\Controller\ChangePasswordForUserController:getForm')->setName("changePWForUser");
        $this->post("/adminservice/change/password/{id}", '\Source\Controller\ChangePasswordForUserController:changePassword')->setName("changePWForUser.post");
        $this->get("/userservice/usertable", '\Source\Controller\UsertableController:getTable')->setName("usertable");
        $this->post("/userservice/usertable", '\Source\Controller\UsertableController:deleteUser')->setName("usertable.post");

    })->add(new AdminMiddleware($container));

})->add(new AuthorizedMiddleware($container));
