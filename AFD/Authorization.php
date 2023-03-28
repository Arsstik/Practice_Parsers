<?php

namespace App\Feeds\Vendors\AFD;

use App\Feeds\Authorization\HttpAuthorisation;

class Authorization extends HttpAuthorisation
{
    public function beforeAuthorization(): void
    {

        $this->getParams()
            ->setCheckLoginText( 'Sign out' )
            ->setAuthLink( 'https://afdhome.com/login.php' )
            ->setAuthFormLink( 'https://afdhome.com/login.php' )
            ->setAuthInfo( 'email_address', $this->getLogin() )
            ->setAuthInfo( 'password', $this->getPassword() );
    }
}