import { defineStore } from "pinia";

export const useAppStore = defineStore("app", {
  state: () => ({
    panier: JSON.parse(localStorage.getItem("panier")) || [], // Charger le panier depuis le localStorage
    produits: [], // Liste des produits chargés depuis l'API
  }),
  actions: {
    async fetchProduits() {
      try {
        const response = await fetch("/Labo03/api/produits"); // URL de votre API
        const data = await response.json();
        // Convertir les prix en nombres pour éviter les erreurs
        this.produits = data.map((produit) => ({
          ...produit,
          prix: parseFloat(produit.prix), // Convertir le prix en nombre
        }));
      } catch (error) {
        console.error("Erreur lors de la récupération des produits:", error);
      }
    },
    addToCart(product) {
      this.panier.push({
        ...product,
        prix: parseFloat(product.prix), // Convertir le prix en nombre
      });
      localStorage.setItem("panier", JSON.stringify(this.panier)); // Sauvegarde dans le localStorage
    },
    removeFromCart(index) {
      this.panier.splice(index, 1); // Supprimer un produit du panier
      localStorage.setItem("panier", JSON.stringify(this.panier)); // Mise à jour du localStorage
    },
    clearCart() {
      this.panier = []; // Vider le panier
      localStorage.removeItem("panier"); // Supprimer du localStorage
    },
  },
});
