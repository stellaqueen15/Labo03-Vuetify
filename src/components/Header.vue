<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const isLoggedIn = ref(false);
const router = useRouter();

const toggleDrawer = () => {
  // Fonction pour activer/désactiver le menu
};

const logout = async () => {
  try {
    const response = await fetch("/Labo03/api/deconnexion", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
    });
    const data = await response.json();
    if (data.success) {
      isLoggedIn.value = false;
      router.push("/connexion");
    } else {
      console.error("Erreur lors de la déconnexion:", data.message);
    }
  } catch (error) {
    console.error("Erreur réseau lors de la déconnexion:", error);
  }
};

// Vérifier le statut de la connexion à l'initialisation
onMounted(async () => {
  try {
    const response = await fetch("/Labo03/api/check-login", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });
    const data = await response.json();
    isLoggedIn.value = data.loggedIn || false;
  } catch (error) {
    console.error("Erreur de connexion:", error);
    isLoggedIn.value = false;
  }
});
</script>

<template>
  <v-toolbar color="indigo" elevate-on-scroll rounded class="menu">
    <v-toolbar-side-icon
      @click="toggleDrawer"
      class="d-md-none"
    ></v-toolbar-side-icon>

    <v-toolbar-title class="toolbar-title">Rich Ricasso</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-btn to="/" class="nav-btn">Accueil</v-btn>
    <v-btn to="/catalogue" class="nav-btn">Catalogue</v-btn>

    <v-btn v-if="isLoggedIn" to="/profil" class="nav-btn">Profil</v-btn>
    <v-btn v-if="isLoggedIn" to="/panier" class="nav-btn">Panier</v-btn>

    <v-btn v-if="isLoggedIn" @click="logout" class="auth-btn">
      Déconnexion
    </v-btn>

    <v-btn v-if="!isLoggedIn" to="/connexion" class="auth-btn">Connexion</v-btn>
    <v-btn v-if="!isLoggedIn" to="/inscription" class="auth-btn">
      Inscription
    </v-btn>
  </v-toolbar>
</template>

<style scoped>
.menu {
  background: linear-gradient(-135deg, rgb(159, 34, 187), rgb(110, 19, 152));
  color: white;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 0 16px;
}

.toolbar-title {
  font-family: "Sora", sans-serif;
  font-size: 1.2rem;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
}

/* Boutons de navigation */
.nav-btn {
  font-size: 1rem;
  color: white;
  text-transform: capitalize;
  margin: 0 12px;
  transition: all 0.3s ease;
}

.nav-btn:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 25px;
  transform: translateY(-2px);
}

/* Bouton de déconnexion */
.auth-btn {
  background-color: #ac2cc0;
  color: white;
  border-radius: 20px;
  padding: 8px 20px;
  font-weight: bold;
  transition: all 0.3s ease;
  margin: 0 12px;
}

.auth-btn:hover {
  background-color: #b748ca;
  transform: translateY(-2px);
}

@media (max-width: 600px) {
  .menu .v-btn {
    font-size: 0.9rem;
    margin: 0 8px;
  }

  .toolbar-title {
    font-size: 1.5rem;
  }
}

/* Style du menu hamburger */
.menu .v-toolbar-side-icon {
  color: white;
  font-size: 2rem;
  padding: 10px;
}

/* Ajouter un effet de transition au toolbar pour smooth scroll */
.v-toolbar {
  transition: all 0.3s ease;
}

/* Customisation du spacer pour garder un alignement propre */
.menu .v-spacer {
  flex-grow: 1;
}
</style>
