<template>
  <v-container>
    <v-card class="fenetre">
      <v-card-title class="barre">
        <span class="titre-fenetre">Modifier le Profil</span>
        <v-spacer></v-spacer>
        <v-btn icon small class="fermer" @click="goBack">
          <v-icon>X</v-icon>
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
          <v-btn color="primary" type="submit" class="mt-4">Enregistrer</v-btn>
          <v-btn color="grey" class="mt-4" @click="goBack">Annuler</v-btn>
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
const rules = {
  required: (value) => !!value || "Ce champ est requis.",
  email: (value) => /.+@.+\..+/.test(value) || "Email invalide.",
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
      body: JSON.stringify({ name: name.value, email: email.value }),
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
}

.barre {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.v-btn.fermer {
  color: red;
}

.mt-4 {
  margin-top: 16px;
}
</style>
