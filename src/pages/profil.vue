<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Fenêtre Profil</span>
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

      <v-card-text class="contenu-profil">
        <v-container v-if="user" class="profil-content">
          <v-row>
            <v-col cols="12">
              <h2 class="nom-user">Bonjour, {{ user.name }} !</h2>
            </v-col>
            <v-col cols="12">
              <p class="email-user">Email : {{ user.email }}</p>
            </v-col>
            <v-col cols="12" class="options">
              <v-btn color="primary" @click="editUser">Modifier</v-btn>
              <v-btn color="red" @click="deleteUser">Supprimer</v-btn>
            </v-col>
          </v-row>
        </v-container>
        <v-container v-else-if="error" class="error-content">
          <v-row>
            <v-col cols="12">
              <p class="error-message">Erreur : {{ error }}</p>
              <v-btn color="primary" @click="retryFetchProfile">
                Réessayer
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
        <v-card-text v-else>
          <v-progress-circular
            indeterminate
            color="primary"
          ></v-progress-circular>
          <p>Chargement...</p>
        </v-card-text>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const user = ref(null);
const error = ref(null);

const fetchUserProfile = async () => {
  error.value = null; // Réinitialise l'erreur
  try {
    const response = await fetch("/Labo03/api/user/profil", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      let errorData = {};
      try {
        errorData = await response.json();
      } catch {
        errorData.message = "Réponse inattendue du serveur.";
      }
      console.error("Erreur backend :", errorData.message || "Erreur inconnue");
      if (response.status === 401) {
        alert("Veuillez vous connecter pour accéder au profil.");
        router.push("/connexion");
      }
      throw new Error(
        errorData.message || "Erreur lors de la récupération du profil."
      );
    }

    const data = await response.json();
    if (data.success) {
      user.value = data.user;
    } else {
      throw new Error(data.message || "Erreur inconnue.");
    }
  } catch (err) {
    error.value = err.message || "Impossible de charger le profil.";
    console.error("Erreur de chargement du profil :", err);
  }
};

const retryFetchProfile = () => {
  fetchUserProfile();
};

const deleteUser = async () => {
  if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ?")) {
    try {
      const response = await fetch("/Labo03/api/user", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      });

      const data = await response.json();

      if (response.ok) {
        alert(data.message || "Compte supprimé avec succès.");
        router.push("/connexion");
      } else {
        alert(data.message || "Erreur lors de la suppression du compte.");
      }
    } catch (error) {
      console.error("Erreur lors de la suppression :", error);
      alert("Une erreur est survenue.");
    }
  }
};

const editUser = () => {
  router.push("/modification");
};

onMounted(() => {
  fetchUserProfile();
});
</script>

<style scoped>
.contenu-profil {
  background: url(images/Fond-produits.png), url(images/fond_3.png);
  background-position: center, 0px 0px;
  height: 250px;
  text-align: center;
  padding: 20px;
}

.nom-user {
  font-size: 30px;
  font-weight: 500;
  margin-top: 10px;
}

.email-user {
  font-size: 18px;
  margin-top: 10px;
}

.error-message {
  color: red;
  font-size: 18px;
}
</style>
