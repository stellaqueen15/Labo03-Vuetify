panier.vue :
<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Panier</span>
        <v-spacer></v-spacer>
        <v-btn icon small class="moins">
          <v-icon>-</v-icon>
        </v-btn>
        <v-btn icon small class="ouvrir">
          <v-icon>[ ]</v-icon>
        </v-btn>
        <v-btn icon small class="fermer">
          <v-icon>X</v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <v-list class="liste-panier">
          <v-list-item
            v-for="(item, index) in cart"
            :key="index"
            class="fenetre-panier"
          >
            <v-card class="barre-panier">
              <v-card-title>{{ item.name }}</v-card-title>
              <v-card-actions class="boutons-fenetre-panier">
                <v-btn icon small class="moins">
                  <v-icon>-</v-icon>
                </v-btn>
                <v-btn icon small class="ouvrir">
                  <v-icon>[ ]</v-icon>
                </v-btn>
                <v-btn icon small @click="removeItem(index)" class="fermer">
                  <v-icon>mdi-close</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>

            <v-row class="conteneur">
              <v-col cols="4">
                <v-img :src="item.image" :alt="item.name" width="150"></v-img>
              </v-col>
              <v-col cols="8">
                <p>{{ parseFloat(item.prix).toFixed(2) }} €</p>
              </v-col>
            </v-row>
          </v-list-item>
        </v-list>

        <v-card-actions class="conteneur-panier">
          <v-card-text class="prix-total"
            >Total : {{ total.toFixed(2) }} €</v-card-text
          >
          <v-btn
            color="primary"
            class="boutonValiderPanier"
            @click="validateCart"
          >
            Valider le Panier
          </v-btn>
        </v-card-actions>

        <v-card-text v-if="cart.length === 0" class="loading">
          Votre panier est vide.
        </v-card-text>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { computed } from "vue";
import { useAppStore } from "@/stores/app";

const store = useAppStore();

const cart = computed(() => store.panier);

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + parseFloat(item.prix), 0)
);

const removeItem = (index) => {
  store.removeFromCart(index);
};

const validateCart = () => {
  store.clearCart();
  alert("Votre commande a été validée.");
};
</script>

<style scoped>
.liste-panier {
  list-style: none;
  margin-left: 0;
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
}

.boutons-fenetre-panier .v-btn {
  cursor: pointer;
}

.prix-total {
  text-align: center;
  font-weight: 600;
}

.boutonValiderPanier {
  margin-top: 10px;
}

.conteneur {
  display: flex;
  align-items: center;
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
