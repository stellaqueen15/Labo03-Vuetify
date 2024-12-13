<template>
  <v-container class="login-container">
    <v-row justify="center" align="center" class="login-row pa-4">
      <v-col cols="12" md="6">
        <v-card class="login-card">
          <v-card-title class="login-title">Connexion</v-card-title>

          <v-form @submit.prevent="handleLogin" class="login-form">
            <v-text-field
              label="Email"
              v-model="email"
              type="email"
              required
              outlined
              variant="solo"
              class="login-input"
            ></v-text-field>

            <v-text-field
              label="Mot de passe"
              v-model="password"
              type="password"
              required
              outlined
              variant="solo"
              class="login-input"
            ></v-text-field>

            <v-btn type="submit" block class="login-btn"> Se connecter </v-btn>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");

const router = useRouter();

const handleLogin = () => {
  fetch("/Labo03/api/login", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      email: email.value,
      password: password.value,
    }),
  })
    .then((response) => {
      console.log("Réponse brute du serveur:", response);
      if (!response.ok) {
        throw new Error(`Erreur HTTP: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      console.log("Données retournées:", data);
      try {
        const jsonData = JSON.parse(data);
        console.log("Réponse JSON:", jsonData);
        if (jsonData.success) {
          alert("Connexion réussie !");
          router.push("/accueil");
        } else {
          alert(jsonData.message);
        }
      } catch (error) {
        console.error("Erreur lors du parsing JSON:", error);
        alert("Une erreur est survenue. Veuillez réessayer.");
      }
    })
    .catch((error) => {
      console.error("Erreur de connexion:", error);
      alert("Une erreur est survenue. Veuillez réessayer.");
    });
};
</script>

<style scoped>
.login-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-row {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-card {
  width: 400px;
  background: linear-gradient(180deg, #a728cb, #b217a3);
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-left: -21px;
  transition: box-shadow 0.3s ease-in-out;
}

.login-card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.login-title {
  text-align: center;
  font-size: 1.6rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 10px;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.login-input {
  border-radius: 16px;
  padding: 10px;
  font-size: 1rem;
  background-color: #7f1e86a0;
  transition: border 0.3s ease;
}

.login-input .v-input__control {
  transition: border-color 0.3s ease;
}

.login-input:focus-within .v-input__control {
  border-color: #4caf50;
}

.login-btn {
  background: #972497;
  color: white;
  font-weight: 600;
  border-radius: 8px;
  padding: 14px;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.login-btn:hover {
  background-color: #a736a7;
  transform: translateY(-3px);
}

.login-btn:active {
  background-color: #a331a3;
  color: white;
  transform: translateY(1px);
}
</style>
