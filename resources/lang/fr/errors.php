<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom Error Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines contain custom error messages for the
    | application. These messages are used for various error scenarios.
    |
    */

    // HTTP Status Codes
    '400' => 'Requête incorrecte',
    '401' => 'Non autorisé',
    '403' => 'Accès interdit',
    '404' => 'Page non trouvée',
    '405' => 'Méthode non autorisée',
    '408' => 'Délai d\'attente dépassé',
    '419' => 'Page expirée',
    '422' => 'Entité non traitable',
    '429' => 'Trop de requêtes',
    '500' => 'Erreur serveur interne',
    '502' => 'Passerelle incorrecte',
    '503' => 'Service indisponible',
    '504' => 'Délai d\'attente de la passerelle',

    // Application Errors
    'generic' => 'Une erreur est survenue',
    'not_found' => 'Élément non trouvé',
    'unauthorized' => 'Non autorisé',
    'forbidden' => 'Accès interdit',
    'server_error' => 'Erreur serveur',
    'validation_error' => 'Erreurs de validation',
    'file_upload_error' => 'Erreur lors du téléchargement du fichier',
    'file_too_large' => 'Le fichier est trop volumineux',
    'file_type_not_allowed' => 'Type de fichier non autorisé',
    'database_error' => 'Erreur de base de données',
    'network_error' => 'Erreur réseau',
    'timeout' => 'Délai d\'attente dépassé',
    'maintenance' => 'Maintenance en cours',
    'page_expired' => 'Page expirée',
    'csrf_token_invalid' => 'Token CSRF invalide',
    'session_expired' => 'Session expirée',
    'login_required' => 'Connexion requise',
    'permission_denied' => 'Permission refusée',
    'resource_not_found' => 'Ressource non trouvée',
    'method_not_allowed' => 'Méthode non autorisée',
    'too_many_requests' => 'Trop de requêtes',
    'service_unavailable' => 'Service indisponible',

    // Form Errors
    'form_invalid' => 'Le formulaire contient des erreurs',
    'form_submission_failed' => 'Échec de la soumission du formulaire',
    'required_fields_missing' => 'Des champs obligatoires sont manquants',
    'invalid_data_format' => 'Format de données invalide',
    'duplicate_entry' => 'Cette entrée existe déjà',
    'foreign_key_constraint' => 'Contrainte de clé étrangère violée',
    'unique_constraint' => 'Cette valeur est déjà utilisée',

    // File Upload Errors
    'file_not_found' => 'Fichier non trouvé',
    'file_corrupted' => 'Fichier corrompu',
    'file_permission_denied' => 'Permission de fichier refusée',
    'file_size_exceeded' => 'Taille de fichier dépassée',
    'file_format_not_supported' => 'Format de fichier non supporté',
    'file_upload_failed' => 'Échec du téléchargement du fichier',
    'file_processing_failed' => 'Échec du traitement du fichier',

    // Authentication Errors
    'login_failed' => 'Échec de la connexion',
    'invalid_credentials' => 'Identifiants invalides',
    'account_locked' => 'Compte verrouillé',
    'account_disabled' => 'Compte désactivé',
    'password_expired' => 'Mot de passe expiré',
    'password_reset_failed' => 'Échec de la réinitialisation du mot de passe',
    'email_not_verified' => 'Email non vérifié',
    'two_factor_required' => 'Authentification à deux facteurs requise',
    'two_factor_failed' => 'Échec de l\'authentification à deux facteurs',

    // Database Errors
    'connection_failed' => 'Échec de la connexion à la base de données',
    'query_failed' => 'Échec de la requête',
    'transaction_failed' => 'Échec de la transaction',
    'constraint_violation' => 'Violation de contrainte',
    'deadlock_detected' => 'Interblocage détecté',
    'data_integrity_error' => 'Erreur d\'intégrité des données',

    // API Errors
    'api_key_invalid' => 'Clé API invalide',
    'api_key_expired' => 'Clé API expirée',
    'api_rate_limit_exceeded' => 'Limite de taux API dépassée',
    'api_endpoint_not_found' => 'Point de terminaison API non trouvé',
    'api_method_not_allowed' => 'Méthode API non autorisée',
    'api_unauthorized' => 'API non autorisée',
    'api_forbidden' => 'API interdite',
    'api_server_error' => 'Erreur serveur API',

    // Cache Errors
    'cache_failed' => 'Échec du cache',
    'cache_key_not_found' => 'Clé de cache non trouvée',
    'cache_expired' => 'Cache expiré',
    'cache_corrupted' => 'Cache corrompu',

    // Queue Errors
    'queue_failed' => 'Échec de la file d\'attente',
    'job_failed' => 'Échec du travail',
    'job_timeout' => 'Délai d\'attente du travail dépassé',
    'job_retry_failed' => 'Échec de la nouvelle tentative du travail',

    // Email Errors
    'email_send_failed' => 'Échec de l\'envoi de l\'email',
    'email_template_not_found' => 'Modèle d\'email non trouvé',
    'email_address_invalid' => 'Adresse email invalide',
    'email_service_unavailable' => 'Service email indisponible',

    // Payment Errors
    'payment_failed' => 'Échec du paiement',
    'payment_method_invalid' => 'Méthode de paiement invalide',
    'payment_gateway_error' => 'Erreur de passerelle de paiement',
    'payment_amount_invalid' => 'Montant de paiement invalide',
    'payment_refund_failed' => 'Échec du remboursement',

    // Security Errors
    'security_violation' => 'Violation de sécurité',
    'suspicious_activity' => 'Activité suspecte détectée',
    'brute_force_attempt' => 'Tentative de force brute détectée',
    'malicious_request' => 'Requête malveillante détectée',
    'security_token_invalid' => 'Token de sécurité invalide',

    // System Errors
    'system_overload' => 'Surcharge du système',
    'memory_limit_exceeded' => 'Limite de mémoire dépassée',
    'disk_space_full' => 'Espace disque plein',
    'service_unavailable' => 'Service indisponible',
    'configuration_error' => 'Erreur de configuration',
    'environment_error' => 'Erreur d\'environnement',

    // User-friendly Messages
    'something_went_wrong' => 'Quelque chose s\'est mal passé',
    'please_try_again' => 'Veuillez réessayer',
    'contact_support' => 'Contactez le support technique',
    'check_your_input' => 'Vérifiez vos données',
    'refresh_page' => 'Actualisez la page',
    'clear_cache' => 'Videz le cache',
    'check_connection' => 'Vérifiez votre connexion',
    'try_later' => 'Réessayez plus tard',
];
