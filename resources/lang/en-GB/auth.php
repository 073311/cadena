<?php

return [

    'auth'                  => 'Authentication',
    'profile'               => 'Profile',
    'logout'                => 'Logout',
    'login'                 => 'Login',
    'forgot'                => 'Forgot',
    'login_to'              => 'Login to start your session',
    'remember_me'           => 'Remember Me',
    'forgot_password'       => 'I forgot my password',
    'reset_password'        => 'Reset Password',
    'change_password'       => 'Change Password',
    'enter_email'           => 'Enter Your Email Address',
    'current_email'         => 'Current Email',
    'reset'                 => 'Reset',
    'never'                 => 'never',
    'landing_page'          => 'Landing Page',
    'personal_information'  => 'Personal Information',
    'register_user'         => 'Register User',
    'register'              => 'Register',

    'form_description' => [
        'personal'          => 'The invitation link will be sent to the new user, so ensure that the email address is correct. They will be able to enter their password.',
        'assign'            => 'The user will have access to the selected companies. You can restrict the permissions from the <a href=":url" class="border-b border-black">roles</a> page.',
        'preferences'       => 'Select the default language of the user. You can also set the landing page after the user logs in.',
    ],

    'password' => [
        'pass'              => 'Password',
        'pass_confirm'      => 'Password Confirmation',
        'current'           => 'Current Password',
        'current_confirm'   => 'Current Password Confirmation',
        'new'               => 'New Password',
        'new_confirm'       => 'New Password Confirmation',
    ],

    'error' => [
        'self_delete'       => 'Error: Can not delete yourself!',
        'self_disable'      => 'Error: Can not disable yourself!',
        'unassigned'        => 'Error: Can not unassigned company! The :company company must be assigned at least one user.',
        'no_company'        => 'Error: No company assigned to your account. Please, contact the system administrator.',
    ],

    'login_redirect'        => 'Verification done! You are being redirected...',
    'failed'                => 'These credentials do not match our records.',
    'throttle'              => 'Too many login attempts. Please try again in :seconds seconds.',
    'disabled'              => 'This account is disabled. Please, contact the system administrator.',

    'notification' => [
        'message_1'         => 'You are receiving this email because we received a password reset request for your account.',
        'message_2'         => 'If you did not request a password reset, no further action is required.',
        'button'            => 'Reset Password',
    ],

    'invitation' => [
        'message_1'         => 'You are receiving this email because you are invited to join the ovds.',
        'message_2'         => 'If you do not want to join, no further action is required.',
        'button'            => 'Get started',
    ],

    'information' => [
        'invoice'           => 'Create invoices easily',
        'reports'           => 'Get detailed reports',
        'expense'           => 'Track any expense',
        'customize'         => 'Customize your ovds',
    ],

    'roles' => [
        'admin' => [
            'name'          => 'Admin',
            'description'   => 'They get full access to your ovds including customers, invoices, reports, settings, and apps.',
        ],
        'manager' => [
            'name'          => 'Manager',
            'description'   => 'They get full access to your ovds, but can\'t manage users and apps.',
        ],
        'customer' => [
            'name'          => 'Customer',
            'description'   => 'They can access the Client Portal and pay their invoices online through the payment methods you set up.',
        ],
        'accountant' => [
            'name'          => 'Accountant',
            'description'   => 'They can access invoices, transactions, reports, and create journal entries.',
        ],
        'employee' => [
            'name'          => 'Employee',
            'description'   => 'They can create expense claims and track time for assigned projects, but can only see their own information.',
        ],
    ],

];
