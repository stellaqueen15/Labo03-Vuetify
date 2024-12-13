<script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },
  methods: {
    handleSignup() {
      fetch("/Labo03/api/user", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name: this.name,
          email: this.email,
          password: this.password,
        }),
      })
        .then((response) => {
          console.log("Réponse du serveur:", response);
          if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          console.log(data);
          if (data.success) {
            alert("Inscription réussie !");
            this.$router.push("/connexion");
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          console.error("Erreur lors de l'inscription:", error);
          alert("Une erreur est survenue. Veuillez réessayer.");
        });
    },
  },
};
</script>

<template>
  <v-container class="signup-container">
    <v-row justify="center" align="center" class="signup-row pa-4">
      <v-col cols="12" md="6">
        <!-- Fenêtre d'inscription -->
        <v-card class="signup-card">
          <v-card-title class="signup-title">Inscription</v-card-title>

          <!-- Formulaire d'inscription -->
          <v-form @submit.prevent="handleSignup" class="signup-form">
            <v-text-field
              label="Nom"
              v-model="name"
              required
              outlined
              variant="solo"
              class="signup-input"
            ></v-text-field>

            <v-text-field
              label="Email"
              v-model="email"
              type="email"
              required
              outlined
              variant="solo"
              class="signup-input"
            ></v-text-field>

            <v-text-field
              label="Mot de passe"
              v-model="password"
              type="password"
              required
              outlined
              variant="solo"
              class="signup-input"
            ></v-text-field>

            <v-btn type="submit" block class="signup-btn"> S'inscrire </v-btn>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
.signup-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.signup-row {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.signup-card {
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

.signup-card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.signup-title {
  text-align: center;
  font-size: 1.6rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 10px;
}

.signup-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.signup-input {
  border-radius: 16px;
  padding: 10px;
  font-size: 1rem;
  background-color: #7f1e86a0;
  transition: border 0.3s ease;
}

.signup-input .v-input__control {
  transition: border-color 0.3s ease;
}

.signup-input:focus-within .v-input__control {
  border-color: #4caf50;
}

.signup-btn {
  background: #972497;
  color: white;
  font-weight: 600;
  border-radius: 8px;
  padding: 14px;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.signup-btn:hover {
  background-color: #a736a7;
  transform: translateY(-3px);
}

.signup-btn:active {
  background-color: #a331a3;
  color: white;
  transform: translateY(1px);
}
</style>
