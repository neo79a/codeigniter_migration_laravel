<?php
namespace Ci2Lara\Codeigniter_Migration\Services;

use Illuminate\Support\Facades\Cookie;
use Ci2Lara\Codeigniter_Migration\Models\CodeigniterSession;
use Ci2Lara\Codeigniter_Migration\Libs\Encryption;

class CodeigniterService
{

    public function __construct()
    {
        $cookieName = config('ci_session.sess_cookie_name');
        $cookieValue = Cookie::get($cookieName);

        if(config('ci_session.encrypt_cookie') && config('ci_session.encryption_key')) {
            $cookieValue = (new Encryption())->decode($cookieValue, config('ci_session.encryption_key'));
        }

        $ciSession = unserialize($cookieValue);

        if (isset($ciSession) && isset($ciSession['session_id'])) {
            $sess = CodeigniterSession::find($ciSession['session_id']);
            $this->setUserData($sess);
        } else {
            warning('Could not read session ID from Cookie', [
                'cookieName' => $cookieName,
                'cookieValue' => $cookieValue
            ]);
        }
    }


    public function setUserData($data)
    {
        $this->sessionData = $data;
        $this->userData = unserialize($this->sessionData->user_data);
    }

    public function getUserData()
    {
        if (isset($this->userData) && !empty($this->userData)) {
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
