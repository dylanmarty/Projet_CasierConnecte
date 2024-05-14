<?php

namespace App\Services;

use phpseclib3\Net\SSH2;

class SmsService
{
    protected $ssh;

    public function __construct()
    {
        $this->ssh = new SSH2(env('RASPBERRY_PI_IP'));

        if (!$this->ssh->login(env('PI_USERNAME'), env('PI_PASSWORD'))) {
            throw new \Exception('Failed to connect via SSH');
        }
    }

    public function sendSms($phoneNumber, $message)
    {
        $command = 'gammu-smsd-inject TEXT ' . $phoneNumber . ' -text "' . $message . '"';
        $output = $this->ssh->exec($command);
        return $output;
    }
}
