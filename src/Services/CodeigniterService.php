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

        try {
            $cookieValue = Cookie::get($cookieName);
            
            if (config('ci_session.encrypt_cookie') && config('ci_session.encryption_key')) {
                try {
                    $cookieValue = (new Encryption([
                        'use_mcrypt' => config('ci_session.use_mcrypt')
                    ]))->decode($cookieValue, config('ci_session.encryption_key'));

                    try {
                        $ciSession = unserialize($cookieValue);

                        if (isset($ciSession) && isset($ciSession['session_id'])) {
                            try {
                                $sess = CodeigniterSession::find($ciSession['session_id']);
                                $this->setUserData($sess);
                            } catch (Exception $CouldNotReadSessionDataException) {
                                app('logger')->warning('Legacy Session error', [
                                    'exception' => $CouldNotReadSessionDataException->getMessage(),
                                    '_context' => [
                                        'cookieName' => $cookieName,
                                        'cookieValue' => $cookieValue,
                                        'ciSession' => $ciSession
                                    ]
                                ]);
                            }
                        }
                    } catch (\Exception $CouldNotUnserializeCookieValueException) {
                        app('logger')->warning('CouldNotUnserializeCookieValueException', [
                            'exception' => $CouldNotUnserializeCookieValueException->getMessage()
                        ]);
                    }
                } catch (\Exception $CouldNotDecryptCookieException) {
                    app('logger')->warning('CouldNotDecryptCookieException', [
                        'exception' => $CouldNotDecryptCookieException->getMessage()
                    ]);
                }
            }

        } catch (\Exception $GotNoCookieException) {
            app('logger')->warning('GotNoCookieException', [
                'exception' => $GotNoCookieException->getMessage()
            ]);
        }
    }


    public function setUserData($data)
    {
        $this->sessionData = $data;
        if(isset($this->sessionData->user_data)) {
            $this->userData = unserialize($this->sessionData->user_data);
        }
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
