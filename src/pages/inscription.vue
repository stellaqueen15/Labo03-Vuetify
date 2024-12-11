<template>
  <v-container>
    <v-row justify="center" align="center" class="pa-4">
      <v-col cols="12" md="6">
        <!-- Fenêtre d'inscription -->
        <v-card>
          <v-card-title class="text-h5">Inscription</v-card-title>

          <!-- Formulaire d'inscription -->
          <v-form @submit.prevent="handleSignup">
            <v-text-field
              label="Nom"
              v-model="name"
              required
              outlined
            ></v-text-field>

            <v-text-field
              label="Email"
              v-model="email"
              type="email"
              required
              outlined
            ></v-text-field>

            <v-text-field
              label="Mot de passe"
              v-model="password"
              type="password"
              required
              outlined
            ></v-text-field>

            <v-btn type="submit" color="primary" block> S'inscrire </v-btn>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

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

<style>
.contenu-connexion {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.fenetre-connexion {
  width: 400px;
  border: 2px solid black;
  background: linear-gradient(
    360deg,
    rgb(255, 113, 206) 0%,
    rgb(214, 94, 241) 100%
  );
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
  margin: 20px auto;
  text-align: center;
}

.barre-connexion {
  background-color: rgb(141, 28, 186);
  color: white;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.boutons-fenetre-connexion {
  display: flex;
  gap: 10px;
}

.boutons-fenetre-connexion span {
  cursor: pointer;
  background-color: rgb(1, 205, 254);
  color: rgb(0, 0, 0);
  padding: 2px 8px;
  border-radius: 4px;
}

.boutons-fenetre-connexion span:hover {
  background-color: rgb(74, 217, 253);
}

.bloc-connexion input[type="email"],
.bloc-connexion input[type="text"],
.bloc-connexion input[type="password"] {
  border: none;
  width: 200px;
  height: 22px;
}

.bloc-connexion input[type="email"]:focus,
.bloc-connexion input[type="text"]:focus,
.bloc-connexion input[type="password"]:focus {
  outline: none;
  border: 2px solid rgb(255, 113, 206);
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

.bloc-connexion input[type="submit"] {
  background-color: rgb(1, 205, 254);
  font-size: 16px;
  font-weight: 400;
  color: white;
  border: 2px solid black;
  margin-bottom: 10px;
}

.bloc-connexion input[type="submit"]:hover {
  cursor: pointer;
  background: linear-gradient(360deg, rgb(1, 205, 254), rgb(45, 185, 241));
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

.bloc-connexion > a {
  text-decoration: none;
  display: block;
  padding: 4px;
  font-weight: 400;
  margin-right: 300px;
  margin-bottom: 10px;
  color: white;
  background-color: rgb(141, 28, 186);
  border: 2px solid black;
}

.bloc-connexion > a:hover {
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

.contenu-connexion {
  background: url(images/Fond-produits.png), url(images/fond_3.png);
  background-position: center, -210px 0px;
}

.connecter {
  margin-left: 40px;
  width: 110px;
}
</style>
