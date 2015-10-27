<?php
return array(
    'Authorization\Module'                       => __DIR__ . '/Module.php',
    'Authorization\Controller\AuthController'    => __DIR__ . '/src/Authorization/Controller/AuthController.php',
    'Authorization\Controller\SuccessController' => __DIR__ . '/src/Authorization/Controller/SuccessController.php',
    'Authorization\Model\MyAuthStorage'          => __DIR__ . '/src/Authorization/Model/AuthStorage.php',
    'Authorization\Form\LoginForm'               => __DIR__ . '/src/Authorization/Form/LoginForm.php',    
    'Authorization\Model\Users'                  => __DIR__ . '/src/Authorization/Model/Users.php',
    'Authorization\Model\UsersTable'             => __DIR__ . '/src/Authorization/Model/UsersTable.php',
    'Authorization\Model\UserRole'               => __DIR__ . '/src/Authorization/Model/UserRole.php',
    'Authorization\Model\UserRoleTable'          => __DIR__ . '/src/Authorization/Model/UserRoleTable.php'
);