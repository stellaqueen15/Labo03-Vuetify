<script>
export default {
  data() {
    return {
      email: "",
      emailError: "", // pour les erreurs de validation
      message: "", // pour les messages d'erreur ou de succès
      messageType: "", // pour définir le type de message (success ou error)
    };
  },
  methods: {
    // Méthode pour s'abonner à la newsletter
    async subscribe() {
      // Réinitialiser les messages
      this.message = "";
      this.messageType = "";
      this.emailError = "";

      // Validation basique de l'email
      if (!this.email) {
        this.emailError = "L'email est requis";
        return;
      }

      if (!this.isValidEmail(this.email)) {
        this.emailError = "Adresse e-mail invalide";
        return;
      }

      try {
        // Envoi de la requête POST à l'API
        const response = await fetch("/Labo03/api/subscribe-newsletter", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            "email-newsletter": this.email,
          }),
        });

        const data = await response.json();

        if (data.success) {
          this.message = data.message;
          this.messageType = "success"; // Message de succès
        } else {
          this.message = data.message;
          this.messageType = "error"; // Message d'erreur
        }
      } catch (error) {
        // En cas d'erreur de réseau
        this.message = "Une erreur est survenue. Veuillez réessayer.";
        this.messageType = "error";
        console.error("Erreur de requête:", error);
      }
    },

    // Fonction pour valider l'email
    isValidEmail(email) {
      const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return regex.test(email);
    },
  },
};
</script>

<template>
  <v-footer padless>
    <v-container class="text-center">
      <v-row justify="center">
        <v-col cols="12" md="6">
          <v-container
            class="d-flex flex-row align-center newsletter-section"
            style="gap: 15px"
          >
            <v-typography variant="h5">
              Abonnez-vous à notre infolettre !
            </v-typography>

            <v-form @submit.prevent="subscribe" class="d-flex align-center">
              <v-text-field
                v-model="email"
                label="Votre adresse e-mail"
                type="email"
                placeholder="Entrez votre email"
                variant="solo"
                required
                outlined
                dense
                :error-messages="emailError"
                style="margin-right: 8px; width: 300px"
              ></v-text-field>
              <v-btn type="submit" color="primary" class="sora-font">
                S'abonner
              </v-btn>
            </v-form>

            <v-alert
              v-if="message"
              :type="messageType"
              dense
              class="ml-4"
              :value="true"
            >
              {{ message }}
            </v-alert>
          </v-container>
        </v-col>
      </v-row>

      <v-divider></v-divider>

      <v-row justify="center">
        <v-col cols="12" class="text-center">
          <v-typography variant="body-2">
            Site créé par Brenda et Tarek - Copyright
          </v-typography>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<style>
.v-container.newsletter-section {
  height: 100px;
  background: linear-gradient(-90deg, rgb(1, 205, 254), rgb(175, 233, 255));
  width: 900px;
  border-radius: 80px;
  border: 2px solid black;
}
</style>
