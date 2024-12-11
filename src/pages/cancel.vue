<template>
  <v-container>
    <v-card>
      <v-card-title>Paiement annulé</v-card-title>
      <v-card-text>
        Vous avez annulé votre paiement. Vous pouvez revenir au panier ou
        continuer vos achats.
      </v-card-text>
      <v-btn @click="$router.push('/panier')">Retour au panier</v-btn>
    </v-card>
  </v-container>
</template>

<script setup>
// Logique si nécessaire
</script>
