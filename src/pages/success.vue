<template>
  <v-container>
    <v-card>
      <v-card-title>Merci pour votre achat !</v-card-title>
      <v-card-text>
        Votre paiement a été effectué avec succès. Vous pouvez revenir à
        l'accueil ou consulter vos commandes.
      </v-card-text>
      <v-btn @click="$router.push('/')">Retour à l'accueil</v-btn>
    </v-card>
  </v-container>
</template>

<script setup></script>
