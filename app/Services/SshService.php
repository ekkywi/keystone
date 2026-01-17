<?php

namespace App\Services;

use App\Models\Server;
use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;
use Exception;

class SshService
{
    protected $ssh;
    protected $timeout = 60;

    public function connect(Server $server)
    {
        try {
            $this->ssh = new SSH2($server->ip_address, $server->ssh_port ?? 22);

            $key = PublicKeyLoader::load($server->private_key);

            if (!$this->ssh->login($server->user, $key)) {
                throw new Exception("SSH Login Failed. Check username or keys.");
            }

            $this->ssh->setTimeout($this->timeout);
        } catch (Exception $e) {
            throw new Exception("Connection Error: " . $e->getMessage());
        }
    }

    public function execute($command)
    {
        if (!$this->ssh) {
            throw new Exception("No active SSH connection.");
        }

        return $this->ssh->exec($command);
    }

    public function uploadFile($remotePath, $content)
    {
        if (!$this->ssh) {
            throw new Exception("No active SSH connection.");
        }

        $base64Content = base64_encode($content);

        $command = "echo '{$base64Content}' | base64 -d > {$remotePath}";

        $this->execute($command);
    }

    public function ensureDirectoryExists($path)
    {
        $this->execute("mkdir -p {$path}");
    }
}
