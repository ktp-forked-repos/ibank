<?php
namespace IjorTengab\IBank;

/**
 * Trait yang menyajikan fungsi cepat menyediakan fitur-fitur umum
 * dari ibank, seperti get balance (saldo), get transaction history (mutasi
 * rekening), dll.
 */
trait IBankTrait
{
    
    protected static $_error = [];

    public static function getError() 
    {
        return self::$_error;
    }
    
    /**
     * Create a new instance of object.
     *
     * @param $information mixed
     *   Jika string, maka diasumsikan sebagai json, nantinya akan didecode
     *   sehingga menjadi array.
     */
    public static function init($information = null)
    {
        $class = __CLASS__;
        $instance = new $class();
        if (is_string($information)) {
            $information = trim($information);
            $information = json_decode($information, true);
        }
        $information = (array) $information;
        foreach ($information as $key => $value) {
            $instance->set($key, $value);
        }
        return $instance;
    }

    /**
     * Mendapatkan balance (saldo).
     *
     * @param $information mixed
     *   Untuk mendapatkan saldo setidaknya harus ada informasi key 'username'
     *   dan 'password'.
     */
    public static function getBalance($information)
    {
        $instance = self::init($information);
        $instance->target = 'get_balance';
        $instance->execute();
        self::$_error = array_merge(self::$_error, $instance->error);
        return $instance->result;
    }

    public static function getTransaction($information)
    {
        $instance = self::init($information);
        $instance->target = 'get_transaction';
        $instance->execute();
        self::$_error = array_merge(self::$_error, $instance->error);
        return $instance->result;
    }
}
