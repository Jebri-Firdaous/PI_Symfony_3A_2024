<?php

// This is an example PHP file with a namespace declaration

namespace App\Service;

use Stripe\StripeClient;

class StripeService
{
    private $stripe;

    public function __construct(string $stripeApiKey)
    {
        $this->stripe = new StripeClient($stripeApiKey);
    }

    public function createCustomer(string $email, string $paymentMethod): array
    {
        $customer = $this->stripe->customers->create([
            'email' => $email,
            'payment_method' => $paymentMethod,
            'invoice_settings' => [
                'default_payment_method' => $paymentMethod,
            ],
        ]);

        return $customer->toArray();
    }
    public function processPayment(float $amount, string $token, string $cardNumber, string $cardHash): void
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amount * 100, // Le montant doit être en cents
                'currency' => 'eur', // Devise à utiliser pour le paiement
                'payment_method' => $token,
                'description' => 'Paiement pour une commande',
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Erreur liée à la carte, gérer l'exception
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            // Autres erreurs, gérer l'exception
            throw new \Exception('Une erreur est survenue lors du paiement.');
        }
    }

    // Add other methods related to Stripe operations
}
