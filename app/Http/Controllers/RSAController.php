<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;

class RSAController extends Controller {


    public function register(Request $request)
    {
        $private = RSA::createKey();
        // $private = $private->withHash('sha256');
        $publicK = $private->getPublicKey();

        $publicKey = $publicK;
        $privateKey = $private;
        Storage::disk('local')->put("keys/public.pem", $publicKey);
        Storage::disk('local')->put("keys/private.pem", $privateKey);   

        $validatedData['public_key'] = $publicKey;
        $validatedData['private_key'] = $privateKey;
    }

    public function test2(Request $request)
    {
        $publicKey = Storage::disk('local')->get('keys/public.pem');
        $privateKey = Storage::disk('local')->get('keys/private.pem');

        // Tạo đối tượng RSA từ khóa đã đọc
        $private = PublicKeyLoader::load($privateKey);
        $public = PublicKeyLoader::load($publicKey);
        
        // Chuỗi cần mã hóa
        $plaintext = [];
        // Mã hóa

        $publicKeyx = Storage::disk('local')->get('keys/public.pem');
        $privateKeyX = Storage::disk('local')->get('keys/private.pem');
        $rsa = RSA::load($privateKeyX)->withPadding(RSA::ENCRYPTION_PKCS1);

        $pbl = $rsa->getPublicKey();
        $ciphertext = $pbl->withPadding(RSA::ENCRYPTION_PKCS1)->encrypt($plaintext);
        $ciphertext = base64_encode($ciphertext);
        $str = "qs+4Tgt13Z3n/Vj9ue/xNrH8dwOeXfIqm2qnpjnTnrS5+yjEhPhFANARI3CQ6WJ91me0k+bTXqWg+FhvrVuNGKHEseIz0W1InDca6Y+rMNbrlv5vvDL75RiUCHFw0S3XNlRQM1TyvNYvtTpgNRfBcX0/w7o8BI8gD6j59Snqn+koxxTgWYcKi+KQe8c7LCB9hRPFp17tmslSIONWhjBEvLNpWwvPbEjmHGhoGgYVvL3tWkkdFomh3D77UFEXXkMC0IF+kYuMQc0PEjNJlYJ5vmnzSY48Sy7Xjw07FHv26Pc5JFfyBkxt1kcrKm/288H8BgkEjwiG7Hvz1NCkpvn3lw==";
        $decryptedText = $rsa->withPadding(RSA::ENCRYPTION_PKCS1)->decrypt(base64_decode($str));
        
    }

    public function test(Request $request)
    {
        $publicKey = Storage::disk('local')->get('keys/public.pem');
        $privateKey = Storage::disk('local')->get('keys/private.pem');
        
        // Tạo đối tượng RSA từ khóa đã đọc
        $private = PublicKeyLoader::load($privateKey);
        $public = PublicKeyLoader::load($publicKey);
        
        // Chuỗi cần mã hóa
        // Mã hóa

        $publicKeyx = Storage::disk('local')->get('keys/public.pem');
        $privateKeyX = Storage::disk('local')->get('keys/private.pem');
        $rsa = RSA::load($privateKeyX)->withPadding(RSA::ENCRYPTION_PKCS1);

        $str = "qs+4Tgt13Z3n/Vj9ue/xNrH8dwOeXfIqm2qnpjnTnrS5+yjEhPhFANARI3CQ6WJ91me0k+bTXqWg+FhvrVuNGKHEseIz0W1InDca6Y+rMNbrlv5vvDL75RiUCHFw0S3XNlRQM1TyvNYvtTpgNRfBcX0/w7o8BI8gD6j59Snqn+koxxTgWYcKi+KQe8c7LCB9hRPFp17tmslSIONWhjBEvLNpWwvPbEjmHGhoGgYVvL3tWkkdFomh3D77UFEXXkMC0IF+kYuMQc0PEjNJlYJ5vmnzSY48Sy7Xjw07FHv26Pc5JFfyBkxt1kcrKm/288H8BgkEjwiG7Hvz1NCkpvn3lw==";
        $decryptedText = $rsa->withPadding(RSA::ENCRYPTION_PKCS1)->decrypt(base64_decode($str));
        
        dd($decryptedText);
    }

    static public function ecRSA($plaintext = 'Hello, world!') {
        try {
            $publicKey = Storage::disk('local')->get('keys/public.pem');
            $privateKey = Storage::disk('local')->get('keys/private.pem');
            
            // Tạo đối tượng RSA từ khóa đã đọc
            $private = PublicKeyLoader::load($privateKey);
            $public = PublicKeyLoader::load($publicKey);
            
            // Chuỗi cần mã hóa
            $plaintext;
            // Mã hóa
    
            $publicKeyx = Storage::disk('local')->get('keys/public.pem');
            $privateKeyX = Storage::disk('local')->get('keys/private.pem');
            $rsa = RSA::load($privateKeyX)->withPadding(RSA::ENCRYPTION_PKCS1);
    
            $pbl = $rsa->getPublicKey();
            $ciphertext = $pbl->withPadding(RSA::ENCRYPTION_PKCS1)->encrypt($plaintext);
            $ciphertext = base64_encode($ciphertext);
            
            return $ciphertext;
        } catch (\Throwable $th) {
            Log::error("Lỗi encode");
            Log::error($th);
            return $plaintext;
        }
    }

    static public function decRSA($plaintext = 'Hello, world!') {
        try {
            $publicKey = Storage::disk('local')->get('keys/public.pem');
            $privateKey = Storage::disk('local')->get('keys/private.pem');
            
            // Tạo đối tượng RSA từ khóa đã đọc
            $private = PublicKeyLoader::load($privateKey);
            $public = PublicKeyLoader::load($publicKey);
            
            // Chuỗi cần mã hóa
            // Mã hóa

            $publicKeyx = Storage::disk('local')->get('keys/public.pem');
            $privateKeyX = Storage::disk('local')->get('keys/private.pem');
            $rsa = RSA::load($privateKeyX)->withPadding(RSA::ENCRYPTION_PKCS1);

            $decryptedText = $rsa->withPadding(RSA::ENCRYPTION_PKCS1)->decrypt(base64_decode($plaintext));
            return $decryptedText;
        } catch (\Throwable $th) {
            Log::error("Lỗi decode");
            Log::error($th);
            return $plaintext;
        }
    }

}