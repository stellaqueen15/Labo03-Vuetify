<template>
  <v-footer padless>
    <v-container class="text-center">
      <v-row justify="center">
        <v-col cols="12" md="6">
          <div id="newsletter-section">
            <v-typography variant="h5"
              >Abonnez-vous à notre infolettre !</v-typography
            >

            <v-form @submit.prevent="subscribe">
              <v-text-field
                v-model="email"
                label="Votre adresse e-mail"
                type="email"
                placeholder="Entrez votre email"
                required
                outlined
                dense
                :error-messages="emailError"
              ></v-text-field>
              <v-btn type="submit" color="primary" class="sora-font">
                S'abonner
              </v-btn>
            </v-form>

            <!-- Message d'erreur ou de succès -->
            <v-alert
              v-if="message"
              :type="messageType"
              class="mt-4"
              dense
              :value="true"
            >
              {{ message }}
            </v-alert>
          </div>
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

<style>
#newsletter-section,
footer {
  font-weight: bold;
  text-align: center;
}

#newsletter-section {
  height: 95px;
  background: linear-gradient(-90deg, rgb(1, 205, 254), rgb(175, 233, 255));
  width: 700px;
  border-radius: 80px;
  border: 2px solid black;
}

#newsletter-section input[type="email"] {
  border: none;
  width: 200px;
  height: 22px;
  margin-right: 10px;
}

#newsletter-section input[type="email"]::placeholder {
  color: rgb(2, 159, 199);
  opacity: 0.4;
}

#newsletter-section input[type="submit"] {
  background: linear-gradient(90deg, rgb(255, 113, 206), rgb(214, 94, 241));
  font-size: 18px;
  font-weight: 400;
  color: white;
  border: 1px solid black;
}

#newsletter-section input[type="submit"]:hover {
  cursor: pointer;
  background: linear-gradient(90deg, rgb(214, 94, 241), rgb(255, 113, 206));
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

/*ÉCRAN POUR TABLETTE*/
@media (min-width: 768px) and (max-width: 1024px) {
  .fenetre {
    width: 90%;
  }
}
</style>
