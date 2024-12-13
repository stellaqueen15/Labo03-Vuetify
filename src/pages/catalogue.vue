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

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const filters = ref({
  type: "Tous",
  couleur: "Toutes",
  taille: "Toutes",
  prixMin: null,
  prixMax: null,
});

const products = ref([]);

const fetchProducts = async () => {
  try {
    const response = await axios.get("/Labo03/api/produits");
    products.value = response.data;
    console.log("Produits récupérés :", products.value);
  } catch (error) {
    console.error("Erreur lors de la récupération des produits :", error);
  }
};

const filteredProducts = computed(() => {
  return products.value.filter((product) => {
    const matchesType =
      filters.value.type === "Tous" || product.type === filters.value.type;
    const matchesCouleur =
      filters.value.couleur === "Toutes" ||
      product.couleur === filters.value.couleur;
    const matchesTaille =
      filters.value.taille === "Toutes" ||
      product.taille === filters.value.taille;
    const matchesPrixMin =
      filters.value.prixMin === null || product.prix >= filters.value.prixMin;
    const matchesPrixMax =
      filters.value.prixMax === null || product.prix <= filters.value.prixMax;

    return (
      matchesType &&
      matchesCouleur &&
      matchesTaille &&
      matchesPrixMin &&
      matchesPrixMax
    );
  });
});

const filterProducts = () => {
  console.log("Produits filtrés :", filteredProducts.value);
};

onMounted(() => {
  fetchProducts();
});
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
