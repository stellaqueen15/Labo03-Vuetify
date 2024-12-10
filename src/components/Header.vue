<template>
  <v-app-bar :elevation="2" rounded app dark style="background-color: #ff69b4">
    <v-app-bar-nav-icon></v-app-bar-nav-icon>
    <v-toolbar-title>Rich Ricasso</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-btn to="/">Accueil</v-btn>
    <v-btn to="/catalogue">Catalogue</v-btn>

    <!-- Affichage des liens uniquement si l'utilisateur est connecté -->
    <v-btn v-if="isLoggedIn" to="/profil">Profil</v-btn>
    <v-btn v-if="isLoggedIn" to="/panier">Panier</v-btn>
    <v-btn v-if="isLoggedIn" to="/deconnexion" @click="logout"
      >Déconnexion</v-btn
    >

    <!-- Affichage des liens uniquement si l'utilisateur n'est pas connecté -->
    <v-btn v-if="!isLoggedIn" to="/connexion">Connexion</v-btn>
    <v-btn v-if="!isLoggedIn" to="/inscription">Inscription</v-btn>
  </v-app-bar>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: false,
    };
  },
  created() {
    // Vérifier l'état de connexion de l'utilisateur via l'API profil
    this.checkLoginStatus();
  },
  methods: {
    async checkLoginStatus() {
      try {
        // Effectuer une requête GET vers l'API pour vérifier si l'utilisateur est connecté
        const response = await this.$axios.get("/Labo03/api/user/profil");

        if (response.data.success) {
          this.isLoggedIn = true;
        } else {
          this.isLoggedIn = false;
        }
      } catch (error) {
        // En cas d'erreur (par exemple si l'utilisateur n'est pas connecté), on le considère comme déconnecté
        this.isLoggedIn = false;
      }
    },
    logout() {
      // Déconnexion: on supprime le token du sessionStorage
      sessionStorage.removeItem("auth_token");
      this.isLoggedIn = false;
      this.$router.push("/"); // Rediriger vers la page d'accueil
    },
  },
};
</script>

<style scoped>
header {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

menu {
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

menu > a {
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

.header-separateur {
  width: 2px;
  height: 35px;
  background-color: rgba(0, 0, 0, 0.152);
}
</style>
