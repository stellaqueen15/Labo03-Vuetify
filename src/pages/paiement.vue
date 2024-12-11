<template>
  <v-container>
    <v-btn @click="createCheckoutSession" color="primary">
      Aller au paiement
    </v-btn>
  </v-container>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";

export default {
  data() {
    return {
      stripe: null,
    };
  },
  mounted() {
    this.stripe = loadStripe(
      "pk_test_51QUwMsHysDGSSOG5GRasYqfxtx1fUgHUEdtieFTXW3KkfSuyvYHHSH6t4HXPWk4gTRfubTN0J89oKoRkHlZwrJl700HBoG1GVC"
    ); // Remplace par ta clé publique Stripe
  },
  methods: {
    async createCheckoutSession() {
      try {
        // Appeler ton API pour créer la session de paiement Stripe
        const response = await fetch("/Labo03/checkout.php", {
          method: "POST",
        });

        const session = await response.json();
        const { id: sessionId } = session;

        // Rediriger vers la page de paiement Stripe
        const { error } = await this.stripe.redirectToCheckout({ sessionId });
        if (error) {
          console.error(error);
        }
      } catch (error) {
        console.error("Erreur de création de session Stripe", error);
      }
    },
  },
};
</script>
