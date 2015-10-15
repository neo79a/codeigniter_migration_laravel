<?php
namespace Ci2Lara\Codeigniter_Migration\Services;

use Cookie;
use Ci2Lara\Codeigniter_Migration\Models\CodeigniterSession;


class CodeigniterService
{

    public function __construct() 
    {
        $cookieName = config('ci_session.sess_cookie_name');
        $cookieValue = Cookie::get($cookieName);
        $ciSession = unserialize($cookieValue);
        
        if (isset($ciSession) && isset($ciSession['session_id'])) {
            $sess = CodeigniterSession::find($ciSession['session_id']);
            $this->setUserData($sess);
        }
    }


    public function setUserData($data)
    {
        $this->sessionData = $data;
        $this->userData = unserialize($this->sessionData->user_data);
    }

    public function getUserData()
    {
        if (isset($this->userData)) {
            return $this->userData;
        } else {
            return null;
        }
    }

    public function getConfigData()
    {
        if (isset($this->userData['ci_config'])) {
            return (object) $this->userData['ci_config'];
        } else {
            return null;
        }
    }


    
}
