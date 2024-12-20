<template>
  <v-footer class="custom-footer" padless>
    <v-container>
      <!-- Infolettre Section -->
      <v-row justify="center" class="newsletter-section">
        <v-col cols="12" md="8" lg="6" class="text-center">
          <h2 class="newsletter-title">Abonnez-vous à notre infolettre !</h2>
          <p class="newsletter-description">
            Recevez nos dernières nouvelles, offres exclusives et plus encore
            directement dans votre boite mail.
          </p>

          <v-form @submit.prevent="subscribe" class="newsletter-form">
            <v-text-field
              v-model="email"
              label="Votre adresse e-mail"
              type="email"
              variant="outlined"
              required
              dense
              :error-messages="emailError"
              class="newsletter-input"
            ></v-text-field>

            <v-btn type="submit" class="newsletter-button" elevation="2">
              S'abonner
            </v-btn>
          </v-form>
          <v-alert
            v-if="message"
            :type="messageType"
            dense
            class="newsletter-alert"
          >
            {{ message }}
          </v-alert>
        </v-col>
      </v-row>

      <v-divider class="my-4"></v-divider>

      <!-- Footer Bottom -->
      <v-row justify="center">
        <v-col cols="12" class="text-center">
          <p class="footer-credits">
            Site créé par Brenda et Tarek - &copy; 2024 Tous droits réservés.
          </p>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script setup>
import { ref } from "vue";

const email = ref("");
const emailError = ref("");
const message = ref("");
const messageType = ref("");

const subscribe = async () => {
  message.value = "";
  messageType.value = "";
  emailError.value = "";

  if (!email.value) {
    console.log("Email vide !");
    emailError.value = "L'email est requis.";
    return;
  }

  if (!isValidEmail(email.value)) {
    console.log("Email invalide détecté : ", email.value);
    emailError.value = "Adresse e-mail invalide.";
    return;
  }

  try {
    console.log("Envoi de la requête avec l'email : ", email.value);
    const response = await fetch("/Labo03/api/subscribe-newsletter", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        "email-newsletter": email.value,
      }),
    });

    console.log("Réponse reçue :", response);
    if (!response.ok) {
      throw new Error(`Erreur HTTP : ${response.status}`);
    }

    const data = await response.json();
    console.log("Données reçues :", data);

    if (data.success) {
      message.value = "Vous êtes abonné avec succès !";
      messageType.value = "success";
      email.value = "";
    } else {
      message.value = data.message || "Erreur lors de l'inscription.";
      messageType.value = "error";
    }
  } catch (error) {
    console.error("Erreur de requête :", error);
    message.value = "Une erreur est survenue. Veuillez réessayer.";
    messageType.value = "error";
  }
};

const isValidEmail = (email) => {
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  return regex.test(email);
};
</script>

<style scoped>
.custom-footer {
  background: linear-gradient(135deg, rgb(159, 34, 187), rgb(110, 19, 152));
  color: white;
  padding: 10px 0;
  font-family: "Roboto", sans-serif;
}

.newsletter-section {
  text-align: center;
}

.newsletter-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.newsletter-description {
  font-size: 16px;
  margin-bottom: 20px;
}

.newsletter-form {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
}

.newsletter-input {
  flex: 1;
  max-width: 300px;
}

.newsletter-button {
  background-color: #a331a3;
  color: white;
  text-transform: none;
  font-weight: bold;
  padding: 10px 20px;
}

.newsletter-button:hover {
  background-color: #851785;
}

.newsletter-alert {
  margin-top: 20px;
  max-width: 400px;
  margin-left: auto;
  margin-right: auto;
}

.footer-credits {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.521);
  margin-top: 15px;
}
</style>
