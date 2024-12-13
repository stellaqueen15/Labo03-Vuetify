<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Fenêtre Profil</span>
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
              <v-btn class="blue-btn" @click="editUser">Modifier</v-btn>
              <v-btn class="blue-btn" @click="deleteUser">Supprimer</v-btn>
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
  error.value = null;
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
.fenetre {
  max-width: 600px;
  margin: 50px auto;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
  border-radius: 12px;
  overflow: hidden;
  background: linear-gradient(180deg, #a728cb, #b217a3);
  color: white;
}

.barre {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: rgb(141, 28, 186);
  padding: 10px 20px;
  color: #fff;
  font-weight: bold;
  font-size: 16px;
  border-bottom: 2px solid rgba(255, 255, 255, 0.3);
}

.titre-fenetre {
  font-family: "Roboto", sans-serif;
  font-size: 18px;
  font-weight: bold;
  text-transform: uppercase;
}

.v-btn {
  color: white !important;
}

.v-btn.fermer {
  color: #ff5757 !important;
}

.contenu-profil {
  background: linear-gradient(
    135deg,
    rgba(255, 255, 255, 0.1),
    rgba(0, 0, 0, 0.1)
  );
  text-align: center;
  padding: 30px;
  border-radius: 0 0 12px 12px;
}

.profil-content {
  text-align: center;
}

.nom-user {
  font-size: 26px;
  font-family: "Poppins", sans-serif;
  font-weight: 700;
  color: #fff;
  margin-bottom: 10px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
}

.email-user {
  font-size: 18px;
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  color: #f3e6f8;
  margin-bottom: 20px;
}

.options {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 20px;
}

.v-btn {
  font-size: 14px;
  font-weight: bold;
  padding: 10px 20px;
  text-transform: uppercase;
  border-radius: 8px;
  transition: all 0.3s ease-in-out;
}

.v-btn.blue-btn {
  background-color: #931eae;
  color: white;
}

.v-btn.blue-btn:hover {
  background-color: #9410b2;
}

.error-content {
  text-align: center;
  padding: 30px;
}

.error-message {
  color: #ff8080;
  font-size: 18px;
  font-weight: bold;
}

.v-progress-circular {
  margin: 20px auto;
}

@media (max-width: 600px) {
  .fenetre {
    margin: 20px;
    max-width: 100%;
  }

  .contenu-profil {
    padding: 20px;
  }

  .options {
    flex-direction: column;
  }

  .v-btn {
    width: 100%;
  }
}
</style>
