<?php

use App\Controllers\BaseController;
use CodeIgniter\Model;

class CustomSessionHandler extends Model implements SessionHandlerInterface
{
    protected $DBGroup ;

    protected $table ;



    public function __construct($DBGroup , $table)
    {
        $this->DBGroup = $DBGroup;
        $this->table = $table;
    }

    public function write(string $id, string $data): bool
    {
        $id = $this->encryptSessionID($id);
        
        $this->db->table($this->table)
            ->replace([
                'session_id' => $id,
                'data' => $data,
                'timestamp' => time(),
            ]);

        return true;
    }


    public function open(string $path, string $name): bool
    {
        // manokatra anle connection ohatra 
        if (empty($this->db->connID)) 
        {
            $this->db->initialize();

            return true;
        }
    }

    public function close(): bool
    {

        return true;
    }

    public function read(string $id): string|false
    {
        $id = $this->encryptSessionID($id);

        $sessionRow = $this->db->table($this->table)
        ->where('session_id', $id)
        ->get()
        ->getRow();

        if ($sessionRow) 
        {
            return $sessionRow->data;
        } else 
        {
            return false;
        }

    }
    public function destroy(string $id): bool
    {
        $id = $this->encryptSessionID($id);

        $this->db->table($this->table)
            ->where('session_id', $id)
            ->delete();

        return true;


    }

    public function gc(int $max_lifetime): int|false
    {
        
        $this->db->table($this->table)
            ->where('timestamp <', time() - $max_lifetime)
            ->delete();

        return true;

    }

    private function encryptSessionID ($sessionID)
    {
        return openssl_encrypt($sessionID,'aes-256-cbc',"qwereewq",0,"qazxswedcvfrtgbn");
    }

    private function decryptSessionID ($sessionIDCrypted)
    {
        return openssl_decrypt($sessionIDCrypted,'aes-256-cbc',"qwereewq",0,"qazxswedcvfrtgbn");
    }
    
}
