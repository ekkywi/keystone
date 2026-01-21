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
            throw new \Exception("SSH connection not established.");
        }

        $this->ssh->setTimeout(600);

        $output = $this->ssh->exec($command);

        if ($this->ssh->getExitStatus() !== 0) {
            throw new \Exception("Command failed: " . $output);
        }

        return $output;
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

    public function removeDirectory($path)
    {
        if ($this->ssh) {
            if ($path == '/' || empty($path)) return;
            $this->execute("rm -rf {$path}");
        }
    }
}
