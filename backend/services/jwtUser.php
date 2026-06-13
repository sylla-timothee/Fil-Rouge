<?php

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function token_generation($email, $role, $secret_key) {

    // On crée le header et utilise le hashage 256
    $header = json_encode(['typ' =>'JWT', 'alg' => 'HS256']);
    // On crée le payload 
    $payload = json_encode([
        'email' => $email,
        'role'     => $role,
        'iat'      => time(),               // Date de création (Issued At)
        'exp'      => time() + (60 * 60)    // Expiration : valide pour 1 heure (3600 secondes)
    ]);

    // La on encode
    $base64UrlHeader = base64url_encode($header);
    $base64UrlPayload = base64url_encode($payload);

    // On crée la signature en utilisant la clé secrète et les données
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret_key, true);
    $base64UrlSignature = base64url_encode($signature);

    // On retourne le token complet
    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

// On récupère la clé secrète
$variables_env = parse_ini_file('.env');
$secret_key = $variables_env['SECRET_KEY'];

// On définit les infos de l'utilisateur
$email_utilisateur = "alex@exemple.com"; 
$role_utilisateur = "admin";

// On génère le token
$mon_token = token_generation($email_utilisateur, $role_utilisateur, $secret_key);

// Définir le header
header('Content-Type: application/json');

// On fait le tableau
$reponse = [
    'success' => true,
    'message' => 'Connexion réussie !',
    'token'   => $mon_token
];

// On transforme ce tableau en JSON et on l'envoie
echo json_encode($reponse);

?>