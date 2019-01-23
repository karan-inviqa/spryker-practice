<?php

namespace Karan\Page;

class AdminLoginPage extends Page
{
    protected $path = '/auth/login/';

    protected $elements = [
        'username' => 'auth_username',
        'password' => 'auth_password',
        'submit' => '.btn.btn-success.btn-block.btn-outline.btn'
    ];
    protected $formData = [
        'username' => 'admin@spryker.com',
        'password' => 'change123'
    ];

    public function getLoggedInWithAdminUser()
    {
        $this->fillLoginForm();
        $this->find('css', $this->elements['submit'])->click();
    }

    public function fillLoginForm()
    {
        $formData = $this->formData;
        $elements = $this->elements;

        foreach ($formData as $elementName => $elementValue) {
            $this->fillField($elements[$elementName],$elementValue);
        }
    }
}