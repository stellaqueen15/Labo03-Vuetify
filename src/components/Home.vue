<template>
  <v-container fluid>
    <v-row justify="center" align="center" class="welcome-section">
      <v-col cols="12" sm="10" md="8" lg="6">
        <v-card class="welcome-card" flat>
          <v-img
            src="/images/logo_RichRicasso.png"
            alt="Logo Rich Ricasso"
            height="180px"
            contain
            class="logo-img"
          ></v-img>

          <v-card-title class="text-center brand-title">
            Rich Ricasso
          </v-card-title>
          <v-card-subtitle class="text-center subtitle">
            Une touche d'élégance et d'originalité
          </v-card-subtitle>

          <v-divider></v-divider>
          <v-card-text class="brand-description">
            <p>
              Plongez dans l'univers de Rich Ricasso, où l'élégance rencontre
              l'innovation. Des créations uniques qui allient sophistication et
              une esthétique contemporaine.
            </p>
          </v-card-text>

          <v-carousel hide-delimiters>
            <v-carousel-item
              v-for="(item, index) in carouselImages"
              :key="index"
            >
              <v-img
                :src="item.src"
                :alt="item.alt"
                height="350px"
                class="carousel-image"
              ></v-img>
            </v-carousel-item>
          </v-carousel>
        </v-card>
      </v-col>
    </v-row>

    <v-row justify="center" class="product-gallery">
      <v-col
        v-for="(product, index) in products"
        :key="index"
        cols="12"
        sm="6"
        md="4"
      >
        <v-card class="product-card" @click="viewProduct(product)" outlined>
          <v-img
            :src="product.image"
            alt="Product Image"
            height="220px"
            contain
            class="product-image"
          ></v-img>
        </v-card>
      </v-col>
    </v-row>

    <!-- Modal or detailed view section for the selected product -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title class="headline">Détails du Produit</v-card-title>
        <v-card-text>
          <v-img
            :src="selectedProduct.image"
            alt="Product Image"
            height="300px"
            contain
          ></v-img>
          <p>{{ selectedProduct.description }}</p>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialog = false">Fermer</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref } from "vue";

// Produits et images du carrousel
const products = ref([
  {
    id: 1,
    image: "/images/tie7.webp",
    description: "Une cravate moderne au design élégant.",
  },
  {
    id: 2,
    image: "/images/tshirt3.webp",
    description: "Un t-shirt classique pour un look décontracté.",
  },
  {
    id: 3,
    image: "/images/tshirt6.webp",
    description: "Un t-shirt avec un design original et tendance.",
  },
]);

const carouselImages = ref([
  { src: "/images/tie7.webp", alt: "Cravate Moderne" },
  { src: "/images/tieX.webp", alt: "Cravate X" },
  { src: "/images/tshirt2.webp", alt: "T-Shirt Classique" },
]);

const dialog = ref(false);
const selectedProduct = ref(null);

const viewProduct = (product) => {
  selectedProduct.value = product;
  dialog.value = true;
};
</script>

<style scoped>
.welcome-card {
  margin-top: -30px;
  margin-left: -190px;
  border-radius: 16px;
  background: linear-gradient(180deg, #a728cb, #b217a3);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  width: 750px;
}

.logo-img {
  border-radius: 50%;
  margin: 20px auto;
}

.brand-title {
  font-size: 36px;
  font-weight: bold;
  color: #ffffff;
  text-transform: uppercase;
  letter-spacing: 1.5px;
}

.subtitle {
  font-size: 20px;
  color: #ffffff;
  font-style: italic;
  margin-bottom: 15px;
}

.brand-description {
  font-size: 16px;
  color: #ffffff;
  line-height: 1.6;
  margin: 20px 0;
}

.carousel-image {
  border-radius: 12px;
}

.product-gallery {
  margin-top: 50px;
}

.product-card {
  transition: transform 0.2s ease-in-out;
  border-radius: 12px;
}

.product-card:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.product-image {
  border-radius: 12px;
  background: linear-gradient(180deg, #a728cb, #8f1aa2);
}

.v-row {
  margin-top: 30px;
}

.v-col {
  margin-bottom: 20px;
}

.v-card-subtitle {
  color: #555;
}
</style>
