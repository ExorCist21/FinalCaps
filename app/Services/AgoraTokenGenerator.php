<?php

namespace App\Services;


class AgoraTokenGenerator
{
    const ROLE_PUBLISHER = 1;
    const ROLE_SUBSCRIBER = 2;

    public static function buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role = self::ROLE_PUBLISHER, $expireTimestamp = 3600)
    {
        $timestamp = time() + $expireTimestamp;
        $privilegeExpiredTs = $timestamp;

        $token = self::generateToken($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);

        return $token;
    }

    private static function generateToken($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs)
    {
        $content = self::packContent($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
        $signature = hash_hmac('sha256', $content, $appCertificate, true);

        return base64_encode($signature . $content);
    }

    private static function packContent($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs)
    {
        return $appId . $channelName . $uid . $role . $privilegeExpiredTs;
    }
}
