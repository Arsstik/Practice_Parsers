<?php

namespace App\Feeds\Vendors\AFD;

use App\Feeds\Authorization\HttpAuthorisation;

class Authorization extends HttpAuthorisation
{
    public function beforeAuthorization(): void
    {
        $this->getParams()
            ->setCheckLoginText( 'Sign out' )
            ->setAuthLink( 'https://afdhome.com/login.php?action=check_login' )
            ->setAuthFormLink( 'https://afdhome.com/login.php' )
            ->setAuthInfo( 'login_email', $this->getLogin() )//vrs@s3stores.com
            ->setAuthInfo( 'login_pass', $this->getPassword() );//j2Rse8J3N5xR9W!
    }
}