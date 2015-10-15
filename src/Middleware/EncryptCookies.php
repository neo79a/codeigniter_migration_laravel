<?php

namespace Ci2Lara\Codeigniter_Migration\Middleware;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;

class EncryptCookies extends \Illuminate\Cookie\Middleware\EncryptCookies
{
    
    /**
     * Create a new CookieGuard instance.
     *
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(EncrypterContract $encrypter)
    {
        parent::__construct($encrypter);
        $this->disableFor(config('ci_session.sess_cookie_name'));
    }
}
