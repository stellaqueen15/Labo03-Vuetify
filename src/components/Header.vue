<script>
export default {
  data() {
    return {
      isLoggedIn: false,
    };
  },
  created() {
    this.checkLoginStatus();
  },
  methods: {
    checkLoginStatus() {
      fetch("/Labo03/api/check-login", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.isLoggedIn = data.loggedIn || false;
        })
        .catch((error) => {
          console.error("Erreur de connexion:", error);
          this.isLoggedIn = false;
        });
    },
    logout() {
      fetch("/Labo03/api/deconnexion", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.isLoggedIn = false;
            this.$router.push("/connexion");
          } else {
            console.error("Erreur lors de la déconnexion:", data.message);
          }
        })
        .catch((error) => {
          console.error("Erreur réseau lors de la déconnexion:", error);
        });
    },
  },
};
</script>

<template>
  <v-app-bar :elevation="2" rounded app dark class="menu">
    <v-app-bar-nav-icon></v-app-bar-nav-icon>
    <v-toolbar-title>Rich Ricasso</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-btn to="/">Accueil</v-btn>
    <v-btn to="/catalogue">Catalogue</v-btn>

    <v-btn v-if="isLoggedIn" to="/profil">Profil</v-btn>
    <v-btn v-if="isLoggedIn" to="/panier">Panier</v-btn>
    <v-btn v-if="isLoggedIn" @click="logout">Déconnexion</v-btn>

    <v-btn v-if="!isLoggedIn" to="/connexion">Connexion</v-btn>
    <v-btn v-if="!isLoggedIn" to="/inscription">Inscription</v-btn>
  </v-app-bar>
</template>

<style scoped>
.v-app-bar.header {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.v-app-bar.menu {
  height: 50px;
  background: linear-gradient(-90deg, rgb(1, 205, 254), rgb(175, 233, 255));
  width: 700px;
  margin: 0;
  margin-bottom: 20;
  display: flex;
  flex-direction: row;
  align-items: center;
  border-radius: 30px;
  margin-top: 20px;
  padding: 0;
  border: 2px solid black;
}

.menu > a {
  text-decoration: none;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 10px 0 10px;
  color: black;
  font-weight: 600;
  font-size: 23px;
  width: 200px;
  height: 50px;
  align-items: center;
}

menu > a:hover {
  color: rgb(2, 100, 124);
}
</style>
