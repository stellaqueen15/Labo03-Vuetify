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
    <v-card class="panier-card">
      <v-card-title class="panier-title">
        <span class="panier-titre">Mon Panier</span>
      </v-card-title>

      <v-card-text>
        <v-list class="panier-liste">
          <v-list-item
            v-for="(item, index) in cart"
            :key="index"
            class="panier-item"
          >
            <v-row align="center" class="panier-item-row">
              <v-col cols="3">
                <v-img
                  :src="item.image"
                  :alt="item.name"
                  class="panier-item-image"
                ></v-img>
              </v-col>
              <v-col cols="7">
                <span class="panier-item-name">{{ item.name }}</span>
                <span class="panier-item-price"
                  >{{ parseFloat(item.prix).toFixed(2) }} €</span
                >
              </v-col>
              <v-col cols="2" class="panier-item-actions">
                <v-btn icon @click="removeItem(index)" class="remove-item-btn">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-col>
            </v-row>
          </v-list-item>
        </v-list>

        <v-card-text class="panier-total">
          Total :
          <span class="panier-total-amount">{{ total.toFixed(2) }} €</span>
        </v-card-text>

        <v-btn class="panier-validation-btn" @click="validateCart">
          Valider le Panier
        </v-btn>

        <v-card-text v-if="cart.length === 0" class="panier-empty">
          Votre panier est vide.
        </v-card-text>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<style scoped>
.panier-card {
  width: 100%;
  max-width: 900px;
  margin: 0 auto;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  background: linear-gradient(180deg, #a728cb, #b217a3);
  padding: 20px;
}

.panier-title {
  padding: 16px;
  background-color: #9022ae;
  border-radius: 12px;
  text-align: center;
}

.panier-titre {
  font-size: 1.8rem;
  font-weight: bold;
  color: #ffffff;
}

.panier-liste {
  padding: 0;
  margin: 0;
  background-color: rgb(123, 23, 137);
}

.panier-item {
  margin: 10px 0;
  border-radius: 12px;
  background: linear-gradient(180deg, #9824b8, #961c8a);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.panier-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.panier-item-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px;
}

.panier-item-image {
  max-width: 100%;
  border-radius: 8px;
  object-fit: cover;
}

.panier-item-name {
  font-size: 1.2rem;
  font-weight: 500;
  color: #ffffff;
}

.panier-item-price {
  font-size: 1.1rem;
  color: #ffffff;
  margin-left: 20px;
}

.panier-item-actions {
  display: flex;
  justify-content: flex-end;
}

.remove-item-btn {
  color: #ffffff;
  background-color: #b71985;
  transition: color 0.3s ease;
}

.remove-item-btn:hover {
  color: #d9d9d9;
}

.panier-total {
  font-size: 1.3rem;
  font-weight: 600;
  color: #ffffff;
  padding: 16px;
  text-align: center;
}

.panier-total-amount {
  font-size: 1.5rem;
  color: #ffffff;
}

.panier-validation-btn {
  width: 100%;
  margin-top: 20px;
  padding: 12px;
  font-size: 1.2rem;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, transform 0.2s ease;
  background-color: #851792;
  color: white;
}

.panier-validation-btn:hover {
  background-color: #2196f3;
  transform: translateY(-2px);
}

.panier-validation-btn:active {
  background-color: #1976d2;
  transform: translateY(2px);
}

/* Message si le panier est vide */
.panier-empty {
  font-size: 1.2rem;
  color: #9e9e9e;
  text-align: center;
  margin-top: 20px;
}
</style>
