<?php

use App\Controllers\BaseController;

class CustomSessionHandler extends BaseController implements SessionHandlerInterface
{

    public function write(string $id, string $data): bool
    {
        
        return true;
    }


    public function open(string $path, string $name): bool
    {
        // manokatra anle connection ohatra 

        return true;
    }

    public function close(): bool
    {

        return true;
    }

    public function read(string $id): string|false
    {

        return true;

    }
    public function destroy(string $id): bool
    {
        
        return true;

    }

    public function gc(int $max_lifetime): int|false
    {
        
        return 0;
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
