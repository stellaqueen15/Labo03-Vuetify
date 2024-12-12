<template>
  <v-container>
    <v-card class="product-detail" v-if="product">
      <v-img
        :src="`/${product.image}`"
        :alt="product.name"
        class="product-image"
      ></v-img>
      <v-card-title>{{ product.name }}</v-card-title>
      <v-card-text>
        <p>{{ product.description }}</p>
        <p><strong>Prix :</strong> {{ product.prix }} €</p>
        <p><strong>Couleur :</strong> {{ product.couleur }}</p>
        <p><strong>Taille :</strong> {{ product.taille }}</p>
        <p><strong>Type :</strong> {{ product.type }}</p>
      </v-card-text>
      <v-card-actions class="boutons">
        <router-link to="/catalogue" class="back-link">
          <v-btn prepend-icon="mdi-arrow-left" variant="tonal" color="#c9f3ff">
            Retour au catalogue
          </v-btn>
        </router-link>
        <v-btn
          prepend-icon="mdi-cart"
          variant="tonal"
          color="#f8d2ff"
          @click="addToCart"
          class="add-to-cart"
        >
          Ajouter au panier
        </v-btn>
      </v-card-actions>
    </v-card>

    <v-card class="loading" v-else>
      <v-card-text>Chargement des détails du produit...</v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { useAppStore } from "@/stores/app";
import { useRouter } from "vue-router";

export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      product: null,
    };
  },
  computed: {
    store() {
      return useAppStore();
    },
  },
  watch: {
    id: {
      immediate: true,
      handler(newId) {
        this.fetchProductDetails(newId);
      },
    },
  },
  methods: {
    async fetchProductDetails(productId) {
      try {
        const response = await fetch(`/Labo03/api/produit/${productId}`);
        const data = await response.json();
        this.product = data;
      } catch (error) {
        console.error(
          "Erreur lors de la récupération des détails du produit :",
          error
        );
        this.product = null;
      }
    },
    addToCart() {
      this.store.addToCart(this.product);
      alert("Produit ajouté au panier !");
    },
  },
};
</script>

<style scoped>
.product-detail {
  margin: 20px auto;
  max-width: 600px;
  text-align: center;
  background: linear-gradient(180deg, #a728cb, #b217a3);
  padding: 20px;
  border-radius: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  color: white;
}

.product-image {
  width: 100%;
  max-width: 300px;
  margin: 0 auto 20px;
  border-radius: 50px;
  border: 5px solid #cd1fbc;
}

.add-to-cart {
  margin-top: 20px;
  padding: 10px 20px;
}

.back-link {
  margin-top: 20px;
}

.loading {
  text-align: center;
  font-size: 1.5em;
  color: #6200ea;
}

.boutons {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
