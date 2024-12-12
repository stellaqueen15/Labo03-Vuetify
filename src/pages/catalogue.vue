<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Fenêtre Catalogue</span>
      </v-card-title>
      <v-card class="contenu-fenetre">
        <v-form @submit.prevent="filterProducts" class="form-catalogue">
          <v-row class="contenu-filtrage">
            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="filters.type"
                :items="['Tous', 'Cravate', 'Chemise']"
                variant="solo"
                label="Type de produit"
                style="width: 150px"
                dense
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="filters.couleur"
                :items="['Toutes', 'Bleu', 'Violet', 'Rose', 'Mauve', 'Blanc']"
                variant="solo"
                style="width: 150px"
                label="Couleur"
                dense
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="filters.taille"
                :items="[
                  'Toutes',
                  'Unique',
                  '44',
                  '46',
                  '48',
                  '50',
                  '52',
                  '54',
                  '56',
                ]"
                style="width: 150px"
                variant="solo"
                label="Taille"
                dense
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model.number="filters.prixMin"
                variant="solo"
                label="Prix minimum"
                style="width: 150px"
                type="number"
                dense
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model.number="filters.prixMax"
                variant="solo"
                label="Prix maximum"
                style="width: 150px"
                type="number"
                dense
              ></v-text-field>
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
      </v-card>
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
  background: linear-gradient(180deg, #a728cb, #b217a3);
  border-radius: 16px;
  width: 800px;
}

.contenu-fenetre {
  background: linear-gradient(180deg, #a728cb, #b217a3);
  padding: 20px;
}

.barre {
  display: flex;
  justify-content: space-between;
  background-color: rgb(141, 28, 186);
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
  background: linear-gradient(180deg, #a728cb, #8f1aa2);
  color: white;
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

.contenu-filtrage {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: 37px;
}
</style>
