<?php

class JWTService {
    private $secret_key;

    public function __construct() {
        $variables_env = parse_ini_file(__DIR__ . '/../../.env');
        $this->secret_key = $variables_env['SECRET_KEY'];
    }

    private function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    // ENCODER
    public function generate($email, $role) {
        // On crée le header et utilise le hashage 256
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        // On crée le payload
        $payload = json_encode([
            'email' => $email,
            'role'  => $role,
            'iat'   => time(),
            'exp'   => time() + 3600
        ]);

        // La on encode
        $b64Header = $this->base64url_encode($header);
        $b64Payload = $this->base64url_encode($payload);

         // On crée la signature en utilisant la clé secrète et les données
        $signature = hash_hmac('sha256', $b64Header . "." . $b64Payload, $this->secret_key, true);
        $b64Signature = $this->base64url_encode($signature);

        // On retourne le token complet
        return $b64Header . "." . $b64Payload . "." . $b64Signature;
    }

    // DÉCODER ET VÉRIFIER, fonction publique accessible de partout
    public function verify($token) {
        $parties = explode('.', $token);
        if (count($parties) !== 3) return false;

        list($b64Header, $b64Payload, $b64Signature) = $parties;

        // On revérifie la signature
        $signature_calculee = hash_hmac('sha256', $b64Header . "." . $b64Payload, $this->secret_key, true);
        $b64SignatureCalculee = $this->base64url_encode($signature_calculee);

        if ($b64Signature !== $b64SignatureCalculee) return false; 

       
        $payload = json_decode(base64_decode(strtr($b64Payload, '-_', '+/')), true);
        if ($payload['exp'] < time()) return false; 

        return $payload; // Tout est bon, on renvoie les infos
    }
}