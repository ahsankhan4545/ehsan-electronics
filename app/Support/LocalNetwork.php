<?php

namespace App\Support;

class LocalNetwork
{
    /**
     * Detect this PC's LAN IP (for phone access on same Wi‑Fi).
     */
    public static function lanIp(): ?string
    {
        $candidates = [];

        $hostname = gethostname();
        if ($hostname) {
            foreach (gethostbynamel($hostname) ?: [] as $ip) {
                $candidates[] = $ip;
            }
        }

        if (PHP_OS_FAMILY === 'Windows') {
            $output = (string) shell_exec('ipconfig');
            if (preg_match_all('/IPv4 Address[^\d]*([\d.]+)/i', $output, $matches)) {
                foreach ($matches[1] as $ip) {
                    $candidates[] = $ip;
                }
            }
        }

        foreach (array_unique($candidates) as $ip) {
            if (self::isPrivateLanIp($ip)) {
                return $ip;
            }
        }

        return null;
    }

    public static function isPrivateLanIp(string $ip): bool
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        if (str_starts_with($ip, '127.')) {
            return false;
        }

        return (bool) preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[01])\.)/', $ip);
    }
}
