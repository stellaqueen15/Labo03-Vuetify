<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Modifier le Profil</span>
        <v-spacer></v-spacer>
        <v-btn icon small class="fermer" @click="goBack">
          <v-icon class="my-icon">mdi-close</v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <v-form ref="form" @submit.prevent="updateUser">
          <v-text-field
            v-model="name"
            label="Nom"
            required
            :rules="[rules.required]"
          ></v-text-field>

          <v-text-field
            v-model="email"
            label="Email"
            type="email"
            required
            :rules="[rules.required, rules.email]"
          ></v-text-field>

          <v-text-field
            v-model="currentPassword"
            label="Mot de passe actuel"
            type="password"
            required
            :rules="[rules.required]"
          ></v-text-field>

          <v-text-field
            v-model="newPassword"
            label="Nouveau mot de passe"
            type="password"
            :rules="[rules.password]"
          ></v-text-field>
          <v-btn type="submit" class="blue-btn mt-4">Enregistrer</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const name = ref("");
const email = ref("");
const currentPassword = ref("");
const newPassword = ref("");

const rules = {
  required: (value) => !!value || "Ce champ est requis.",
  email: (value) => /.+@.+\..+/.test(value) || "Email invalide.",
  password: (value) =>
    value.length >= 6 || "Le mot de passe doit contenir au moins 6 caractères.",
};

const fetchUserData = async () => {
  try {
    const response = await fetch("/Labo03/api/user/profil", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(
        "Erreur lors de la récupération des données utilisateur."
      );
    }

    const data = await response.json();
    if (data.success) {
      name.value = data.user.name;
      email.value = data.user.email;
    } else {
      throw new Error(data.message || "Impossible de charger le profil.");
    }
  } catch (error) {
    console.error("Erreur :", error);
    alert("Une erreur est survenue lors du chargement du profil.");
    router.push("/profil");
  }
};

const updateUser = async () => {
  try {
    const response = await fetch("/Labo03/api/user", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        currentPassword: currentPassword.value,
        newPassword: newPassword.value,
      }),
    });

    const data = await response.json();
    if (response.ok) {
      alert("Profil mis à jour avec succès !");
      router.push("/profil");
    } else {
      throw new Error(data.message || "Erreur lors de la mise à jour.");
    }
  } catch (error) {
    console.error("Erreur :", error);
    alert("Une erreur est survenue lors de la mise à jour du profil.");
  }
};

const goBack = () => {
  router.push("/profil");
};

onMounted(() => {
  fetchUserData();
});
</script>

<style scoped>
.fenetre {
  max-width: 500px;
  margin: auto;
  border-radius: 16px;
  background: linear-gradient(180deg, #a728cb, #b217a3);
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  color: white;
  padding: 20px;
}

.barre {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 8px 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  border-radius: 16px;
}

.titre-fenetre {
  font-size: 20px;
  text-transform: uppercase;
}

.v-btn.fermer {
  color: rgb(57, 15, 195);
  font-weight: bold;
  cursor: pointer;
}

.v-card-text {
  text-align: center;
  padding: 16px;
}

.mt-4 {
  margin-top: 16px;
}

.v-btn.blue-btn {
  background-color: #931eae;
  color: white;
  font-weight: bold;
  text-transform: uppercase;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease-in-out;
}

.v-btn.blue-btn:hover {
  background-color: #931eae;
}

.v-text-field {
  background-color: rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  color: white;
  font-weight: bold;
}
</style>
