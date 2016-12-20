<?php

/* *********** Create Routes and Connect them with Controllers ***********
 * warning: put the most specific route to the top!
 * Don't forget about the namespaces!
 */
use \Source\Middleware\AdminMiddleware;
use \Source\Middleware\AuthorizedMiddleware;
use \Source\Middleware\ClientCertificateMiddleware;

// **************************** ROUTES ****************************

// public Routes
$app->group("", function () {

    // ************** Homepage - Routes **************
    // Get the Homepage
    $this->get("/home", '\Source\Controller\HomeController:index')->setName("home");

    // Redirect to Homepage
    $container = $this->getContainer();
    $this->get("/", function ($request, $response) use ($container) {
        return $response->withRedirect($container->router->pathFor('home'));
    });


    // ************** Login/Logout - Routes **************
    // Get the Login page
    $this->get("/authentication/login",'\Source\Controller\Auth\AuthController:index')->setName("login");
    // Post the login data sent by the user
    $this->post("/authentication/login", '\Source\Controller\Auth\AuthController:login')->setName("login.post");
    // Log the the user out
    $this->get("/authentication/logout", '\Source\Controller\Auth\AuthController:logout')->setName("logout");


    // ************** Verify Email **************
    // verify link
    $this->get("/authentication/{userid}/{token}", '\Source\Controller\Auth\AuthController:verify')->setName("verify");


    // ************** Password Request - Routes **************
    // get the password request page
    $this->get("/authentication/passwordRequest",
        '\Source\Controller\Auth\Password\PWRequestController:getForm')->setName("passwordRequest");
    // send the password change link to the given email
    $this->post("/authentication/passwordRequest",
        '\Source\Controller\Auth\Password\PWRequestController:sendLink')->setName("passwordRequest.post");
    // get the create new password page
    $this->get("/authentication/passwordRequest/create/{userid}/{token}",
        '\Source\Controller\Auth\Password\PWRequestController:getCreateNewPWForm')->setName("createNewPW");
    // save the new password
    $this->post("/authentication/passwordRequest/create/{userid}/{token}",
        '\Source\Controller\Auth\Password\PWRequestController:createNewPW')->setName("createNewPW.post");
 })->add(new ClientCertificateMiddleware($container));


// authorized Routes
$app->group("", function () {
    $container = $this->getContainer();

    // ************** Change User Data - Routes **************
    // Get the change password page
    $this->get("/userservice/change/password",
        '\Source\Controller\Auth\Password\ChangePWController:getForm')->setName("changePW");
    // Change the password
    $this->post("/userservice/change/password",
        '\Source\Controller\Auth\Password\ChangePWController:changePassword')->setName("changePW.post");
    // Get the change data page
    $this->get("/userservice/change/data",
        '\Source\Controller\Auth\ChangeDataController:getForm')->setName("changeData");
    // change the data
    $this->post("/userservice/change/data",
        '\Source\Controller\Auth\ChangeDataController:changeData')->setName("changeData.post");

    // admin - routes
    $this->group("", function(){
        // ************** Registration - Routes **************
        //Get the registration page
        $this->get("/registration",
            '\Source\Controller\Auth\RegistrationController:getRegistration')->setName("register");
        // registrate the user
        $this->post("/registration",
            '\Source\Controller\Auth\RegistrationController:postRegistration')->setName("register.post");
        // Get the change-users-pw-page
        $this->get("/adminservice/change/password/{id}",
            '\Source\Controller\Auth\Password\ChangeUsersPWController:getForm')->setName("changeUsersPW");
        // change the users pw
        $this->post("/adminservice/change/password/{id}",
            '\Source\Controller\Auth\Password\ChangeUsersPWController:changePassword')->setName("changeUsersPW.post");
        // Get the change-users-data-page
        $this->get("/adminservice/change/data/{id}",
            '\Source\Controller\Auth\ChangeUsersDataController:getForm')->setName("changeUsersData");
        // change the users data
        $this->post("/adminservice/change/data/{id}",
            '\Source\Controller\Auth\ChangeUsersDataController:changeData')->setName("changeUsersData.post");
        // get the usertable page
        $this->get("/userservice/usertable", '\Source\Controller\UsertableController:getTable')->setName("usertable");
        // delete a user
        $this->post("/userservice/usertable",
            '\Source\Controller\UsertableController:deleteUser')->setName("usertable.post");

    })->add(new AdminMiddleware($container));

})->add(new AuthorizedMiddleware($container));
