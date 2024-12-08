<template>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Panier</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div>
      <ul class="liste-panier">
        <!-- Affiche les produits dans le panier -->
        <li v-for="(item, index) in cart" :key="index">
          <div class="fenetre-panier">
            <div class="barre-panier">
              <span class="titre-fenetre">{{ item.name }}</span>
              <div class="boutons-fenetre-panier">
                <span class="moins">-</span>
                <span class="ouvrir">[ ]</span>
                <button @click="removeFromCart(item.id)" class="fermer">X</button>
              </div>
            </div>
            <div class="conteneur">
              <img :src="item.image" :alt="item.name" width="150" />
              <p>{{ item.prix.toFixed(2) }} €</p>
            </div>
          </div>
        </li>
      </ul>
      <div class="conteneur-panier">
        <p class="prix-total">Total : {{ total.toFixed(2) }} €</p>
        <button class="boutonValiderPanier" @click="validateCart">
          Valider le Panier
        </button>
      </div>
      <p v-if="cart.length === 0">Votre panier est vide.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// État du panier
const cart = ref([]);

// Récupérer les données depuis l'API
fetch('/Labo03/api/produits')
  .then(response => response.json())
  .then(data => {
    cart.value = data;
  })
  .catch(error => {
    console.error('Erreur lors du chargement des produits :', error);
  });

// Calculer le total
const total = computed(() =>
  cart.value.reduce((sum, item) => sum + parseFloat(item.prix), 0)
);

// Supprimer un produit du panier
const removeFromCart = id => {
  fetch(`/Labo03/api/produit/${id}`, {
    method: 'DELETE',
  })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        cart.value = cart.value.filter(item => item.id !== id);
      } else {
        console.error('Erreur lors de la suppression du produit :', result.message);
      }
    });
};

// Valider le panier
const validateCart = () => {
  fetch('/Labo03/api/commande/status?success=1', {
    method: 'GET',
  })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        alert(result.message);
        cart.value = []; // Vider le panier après validation
      } else {
        alert(result.message);
      }
    });
};
</script>

<style>
.liste-panier {
  list-style: none;
  margin-left: -41px;
}

.fenetre-panier {
  width: 900px;
  border: 2px solid black;
  background: linear-gradient(
    360deg,
    rgb(255, 113, 206) 0%,
    rgb(214, 94, 241) 100%
  );
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
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

.boutons-fenetre {
  display: flex;
  gap: 10px;
}

.boutons-fenetre-panier span {
  cursor: pointer;
  background-color: rgb(1, 205, 254);
  color: rgb(0, 0, 0);
  padding: 2px 8px;
  border-radius: 4px;
}

.boutons-fenetre-panier span:hover {
  background-color: rgb(74, 217, 253);
}

.boutons-fenetre-panier button {
  cursor: pointer;
  background-color: rgb(1, 205, 254);
  color: rgb(0, 0, 0);
  padding: 2px 8px;
  border-radius: 4px;
  border: none;
  height: 21px;
  font-weight: 600;
}

.boutons-fenetre-panier button:hover {
  background-color: rgb(74, 217, 253);
}

.prix-total {
  background-color: rgb(141, 28, 186);
  padding: 5px;
  text-align: center;
  color: white;
  font-weight: 600;
}

.boutonValiderPanier {
  background: linear-gradient(
    -90deg,
    rgb(1, 205, 254) 0%,
    rgb(145, 233, 255) 100%
  );
  font-size: 16px;
  border: 2px solid black;
  padding: 10px;
  cursor: pointer;
  margin-bottom: 10px;
}

.boutonValiderPanier:hover {
  background: linear-gradient(
    -90deg,
    rgb(10, 180, 223) 0%,
    rgb(99, 193, 217) 100%
  );
}

.conteneur {
  display: flex;
  align-items: center;
}

.conteneur p {
  margin-left: 10px;
}

.conteneur-panier {
  text-align: center;
}</style>