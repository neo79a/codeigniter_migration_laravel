<?php namespace Ci2Lara\Codeigniter_Migration\Facades;

use Illuminate\Support\Facades\Facade;

class CodeigniterSession extends Facade {
    
    public $username;
    
    
    protected static function getFacadeAccessor() {
        return 'codeigniter_session';
    }
    
}
