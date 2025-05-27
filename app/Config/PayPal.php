<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class PayPal extends BaseConfig
{
    /**
     * PayPal Client ID (Sandbox) - VOTRE VRAIE CLÉ
     */
    public $clientId = 'AQR3nBbUd3qpXICLXXWf4h5Ar6D5WrSeQnroyssVWslHQcEjwDn3JxXgPTR9hiJkbOy2mmf9qjOBELvA';
    
    /**
     * PayPal Client Secret (Sandbox)
     * Pour l'obtenir : developer.paypal.com > Apps & Credentials > votre app > Client Secret
     * (Actuellement pas utilisé dans l'intégration frontend, mais peut être utile pour l'API backend)
     */
    public $clientSecret = 'VOTRE_CLIENT_SECRET_ICI_SI_NECESSAIRE';
    
    /**
     * PayPal Mode (sandbox ou live)
     */
    public $mode = 'sandbox';
    
    /**
     * PayPal API Base URL
     */
    public $baseUrl = 'https://api-m.sandbox.paypal.com';
    
    /**
     * PayPal SDK URL
     */
    public $sdkUrl = 'https://www.paypal.com/sdk/js';
} 