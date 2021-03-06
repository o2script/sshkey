<?php
namespace Codeaken\SshKey;

class SshPublicKey extends SshKey
{
    public function __construct($keyData)
    {
        parent::__construct();

        if ( ! $this->key->loadKey($keyData)) {
            throw new Exception\LoadKeyException();
        }
    }

    public static function fromFile($filename)
    {
        return new SshPublicKey(SshKey::readFile($filename));
    }

    public function getFingerprint()
    {
        $keyParts = explode(' ', $this->getKeyData(SshKey::FORMAT_OPENSSH));

        return implode(':', str_split(md5(base64_decode($keyParts[1])), 2));
    }

    public function getComment()
    {
        return trim($this->key->getComment());
    }

    protected function getKeyType()
    {
        return 'public';
    }
}
