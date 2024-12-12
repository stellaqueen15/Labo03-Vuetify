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

const fetchUserProfile = async () => {
  try {
    const response = await fetch("/Labo03/api/user/profil", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      const errorData = await response.json();
      console.error("Erreur backend :", errorData.message);
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
      alert(data.message || "Erreur inconnue.");
    }
  } catch (error) {
    console.error("Erreur de chargement du profil :", error.message);
  }
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

.profil-image {
  margin-top: 15px;
  border-radius: 50%;
  width: 120px;
  height: 120px;
  object-fit: cover;
  border: 2px solid #000;
}
</style>
