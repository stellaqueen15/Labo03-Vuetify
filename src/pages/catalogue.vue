<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Fenêtre Catalogue</span>
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
        <v-form @submit.prevent="filterProducts" class="form-catalogue">
          <v-row>
            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="filters.type"
                :items="['Tous', 'Cravate', 'Chemise']"
                label="Type de produit"
                dense
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="filters.couleur"
                :items="['Toutes', 'Bleu', 'Violet', 'Rose', 'Mauve', 'Blanc']"
                label="Couleur"
                dense
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="filters.taille"
                :items="['Toutes', 'Unique', '44-56']"
                label="Taille"
                dense
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model.number="filters.prixMin"
                label="Prix minimum"
                type="number"
                dense
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model.number="filters.prixMax"
                label="Prix maximum"
                type="number"
                dense
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-btn type="submit" color="primary">Filtrer</v-btn>
            </v-col>
          </v-row>
        </v-form>

        <div class="product-container">
          <div v-if="filteredProducts.length === 0">Aucun produit trouvé.</div>
          <v-row>
            <v-col
              v-for="product in filteredProducts"
              :key="product.id"
              cols="12"
              sm="6"
              md="4"
            >
              <v-card
                class="product-card"
                :href="`/product_detail/${product.id}`"
              >
                <v-img
                  :src="product.image"
                  :alt="product.name"
                  class="product-image"
                ></v-img>
                <v-card-title>{{ product.name }}</v-card-title>
                <v-card-subtitle>{{ product.prix }} €</v-card-subtitle>
              </v-card>
            </v-col>
          </v-row>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      products: [],
      filters: {
        type: "Tous",
        couleur: "Toutes",
        taille: "Toutes",
        prixMin: null,
        prixMax: null,
      },
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter((product) => {
        const matchesType =
          this.filters.type === "Tous" || product.type === this.filters.type;
        const matchesCouleur =
          this.filters.couleur === "Toutes" ||
          product.couleur === this.filters.couleur;
        const matchesTaille =
          this.filters.taille === "Toutes" ||
          product.taille === this.filters.taille;
        const matchesPrixMin =
          this.filters.prixMin === null || product.prix >= this.filters.prixMin;
        const matchesPrixMax =
          this.filters.prixMax === null || product.prix <= this.filters.prixMax;
        return (
          matchesType &&
          matchesCouleur &&
          matchesTaille &&
          matchesPrixMin &&
          matchesPrixMax
        );
      });
    },
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get("/Labo03/api/produits");
        this.products = response.data;
        console.log("Produits récupérés :", this.products);
      } catch (error) {
        console.error("Erreur lors de la récupération des produits :", error);
      }
    },
    filterProducts() {
      console.log("Produits filtrés :", this.filteredProducts);
    },
  },
  mounted() {
    this.fetchProducts();
  },
};
</script>

<style scoped>
.fenetre {
  background: linear-gradient(180deg, #ff9cee, #fcc4ff);
  border: 2px solid #000000;
  padding: 20px;
  margin: 20px auto;
  max-width: 1200px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

.barre {
  display: flex;
  justify-content: space-between;
  background-color: #6200ea;
  color: #ffffff;
  padding: 10px;
  border-radius: 8px 8px 0 0;
}

.product-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  margin: 20px 0;
}

.product-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
  transform: scale(1.05);
  cursor: pointer;
}

.product-image {
  width: 100%;
  height: auto;
  border-radius: 5px;
}
</style>
