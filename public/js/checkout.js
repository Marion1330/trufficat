// Checkout PayPal functionality
let commandeId = null;

// Configuration PayPal - sera initialisée depuis la vue PHP
window.TrufficatCheckout = {
    config: {},
    
    init: function(config) {
        this.config = config;
        this.initPayPalButtons();
    },
    
    initPayPalButtons: function() {
        paypal.Buttons({
            createOrder: (data, actions) => {
                // Créer la commande côté serveur d'abord
                return fetch(this.config.createOrderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        commandeId = data.commande_id;
                        // Créer le paiement PayPal
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: this.config.total,
                                    currency_code: 'EUR'
                                },
                                description: 'Commande Trufficat #' + data.commande_id
                            }]
                        });
                    } else {
                        throw new Error(data.message || 'Erreur lors de la création de la commande');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la création de la commande: ' + error.message);
                });
            },
            
            onApprove: (data, actions) => {
                document.getElementById('loading').style.display = 'block';
                
                return actions.order.capture().then((details) => {
                    // Rediriger vers la page de succès avec les bonnes informations
                    window.location.href = this.config.successUrl + '?paymentId=' + 
                                           data.orderID + '&PayerID=' + data.payerID + '&commande_id=' + commandeId;
                });
            },
            
            onCancel: (data) => {
                window.location.href = this.config.cancelUrl;
            },
            
            onError: (err) => {
                console.error('Erreur PayPal:', err);
                alert('Une erreur est survenue lors du paiement. Veuillez réessayer.');
                document.getElementById('loading').style.display = 'none';
            }
        }).render('#paypal-button-container');
    }
}; 