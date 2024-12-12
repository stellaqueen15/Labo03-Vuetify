<script setup>
import { computed } from "vue";
import { useAppStore } from "@/stores/app";
import { loadStripe } from "@stripe/stripe-js";

const store = useAppStore();

const cart = computed(() => store.panier);

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + parseFloat(item.prix), 0)
);

const removeItem = (index) => {
  store.removeFromCart(index);
};

const validateCart = async () => {
  const totalAmount = total.value * 100;

  try {
    const response = await fetch("http://localhost:4208/Labo03/checkout.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ totalAmount }),
    });

    const session = await response.json();

    const stripe = Stripe(
      "pk_test_51QUwMsHysDGSSOG5GRasYqfxtx1fUgHUEdtieFTXW3KkfSuyvYHHSH6t4HXPWk4gTRfubTN0J89oKoRkHlZwrJl700HBoG1GVC"
    );
    const { error } = await stripe.redirectToCheckout({
      sessionId: session.id,
    });

    if (error) {
      console.error("Erreur lors de la redirection vers Stripe:", error);
      alert("Une erreur est survenue lors de la tentative de paiement.");
    }
  } catch (error) {
    console.error(
      "Erreur lors de la création de la session de paiement:",
      error
    );
    alert("Une erreur est survenue. Veuillez réessayer.");
  }

  store.clearCart();
};
</script>

<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Panier</span>
      </v-card-title>

      <v-card-text>
        <v-list class="liste-panier fenetre">
          <v-list-item
            v-for="(item, index) in cart"
            :key="index"
            class="fenetre-panier"
          >
            <v-card class="barre-panier">
              <v-card-title>{{ item.name }}</v-card-title>
              <v-card-actions class="boutons-fenetre-panier">
                <v-btn icon small @click="removeItem(index)" class="fermer">
                  <v-icon>mdi-close</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>

            <v-row class="conteneur">
              <v-col cols="4">
                <v-img
                  :src="item.image"
                  :alt="item.name"
                  width="150"
                  class="image-conteneur"
                ></v-img>
              </v-col>
              <v-col cols="8">
                <p>{{ parseFloat(item.prix).toFixed(2) }} €</p>
              </v-col>
            </v-row>
          </v-list-item>
        </v-list>

        <v-card-text class="prix-total"
          >Total : {{ total.toFixed(2) }} €</v-card-text
        >
        <v-btn
          color="#8f1aa2"
          class="boutonValiderPanier"
          prepend-icon="mdi-check"
          @click="validateCart"
        >
          Valider le Panier
        </v-btn>

        <v-card-text v-if="cart.length === 0" class="loading">
          Votre panier est vide.
        </v-card-text>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<style scoped>
.liste-panier {
  list-style: none;
  margin-left: -20px;
}

.fenetre {
  background: linear-gradient(180deg, #a728cb, #b217a3);
  border-radius: 16px;
  width: 800px;
}

.fenetre-panier {
  margin: 20px auto;
}

.barre-panier {
  background-color: rgb(141, 28, 186);
  color: white;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
  border-radius: 20px 20px 0 0;
}

.boutons-fenetre-panier .v-btn {
  cursor: pointer;
}

.prix-total {
  text-align: center;
  font-weight: 500;
  text-transform: uppercase;
  font-size: 20px;
  background-color: #8f1aa2;
  border-radius: 20px;
  padding: 0;
  color: white;
}

.boutonValiderPanier {
  left: 283px;
  margin-top: 20px;
}

.conteneur {
  display: flex;
  align-items: center;
  background-color: #c322ab;
}

.image-conteneur {
  border-radius: 30px;
  margin: 10px 0 10px 10px;
}

.conteneur p {
  margin-left: 10px;
}

.loading {
  text-align: center;
  font-size: 1.5em;
  color: #6200ea;
}
</style>
