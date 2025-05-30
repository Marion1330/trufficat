// Variables globales pour l'application Trufficat
window.TrufficatGlobal = {
    baseUrl: '', // Sera défini par la page PHP
    
    init: function(config) {
        this.baseUrl = config.baseUrl;
        // Garder la compatibilité avec l'ancienne variable globale
        window.baseUrl = this.baseUrl;
    }
}; 