<?php


namespace App\Sessions;
use CodeIgniter\Model;
use SessionHandlerInterface;

class CustomSessionHandler extends Model implements SessionHandlerInterface
{

    protected $DBGroup          = 'clustering';
    protected $table            = 'session';
    protected $primaryKey       = 'pk';
    protected $useAutoIncrement = true;

    public function __construct($DBGroup , $table)
    {

        parent::__construct(); // Initialize the model

        $this->DBGroup = $DBGroup; // Set the database group
        $this->table = $table;
    }

    public function write(string $id, string $data): bool
    {
        $id = $this->encryptSessionID($id);
        $this->db->table($this->table)
            ->replace([
                'cryptedidsession' => $id,
                'sessions' => $data
            ]);

        return true;
    }


    public function open(string $path, string $name): bool
    {
        // manokatra anle connection ohatra 
        return ($this->DBGroup !=null && $this->table !=null) ;

    }

    public function close(): bool
    {

        return true;
    }
    public function read(string $id): string|false
    {

        $id = $this->encryptSessionID($id);
    
        $sessionRow = $this->where('cryptedidsession', $id)->first();
    
        if ($sessionRow) 
        {
            return $sessionRow['sessions'];
        } else 
        {
            return '';
        }
    }
    
    public function destroy(string $id): bool
    {
        $id = $this->encryptSessionID($id);

        $this->db->table($this->table)
            ->where('cryptedidsession', $id)
            ->delete();

        return true;


    }

    public function gc(int $max_lifetime): int|false
    {
        
        $this->db->table($this->table)
            ->where('dateb <', time() - $max_lifetime)
            ->delete();


        return $this->db->affectedRows();

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
