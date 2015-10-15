<?php namespace Ci2Lara\Codeigniter_Migration\Models; 

use Illuminate\Database\Eloquent\Model;


/**
 * 
 */
class CodeigniterSession extends Model
{

    protected $dates = [];
    protected $table = '';
    protected $primaryKey = 'session_id';
    
    public function __construct() 
    {
        $this->table = config('ci_session.sess_table_name');
        
    }
    
    public function isValid()
    {
        if ($this->share_status == 0) {
            return false;
        }
        return true;
    }
    
    public function user_data()
    {
        if (($this->last_activity + (config('ci_session.sess_expiration'))) > time()) {   
            //return unserialize($this->user_data);
        } else {
            return null;
        }
    }


}
