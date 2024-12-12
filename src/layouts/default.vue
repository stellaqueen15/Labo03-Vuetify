<template>
  <v-app>
    <Header />
    <v-main>
      <router-view />
    </v-main>
    <Footer />
  </v-app>
</template>

<script setup>
//
</script>

<style>
html,
body {
  height: 100%;
  margin: 0;
}

.sora-font {
  font-family: "Sora", sans-serif;
  font-optical-sizing: auto;
  font-weight: 200;
  font-style: normal;
}

body {
  font-family: Arial, Helvetica, sans-serif;
  background: url(/images/fond_2.png),
    linear-gradient(
        180deg,
        rgba(185, 103, 255, 1) 0%,
        rgba(255, 207, 234, 1) 100%
      )
      no-repeat;
  background-color: rgba(255, 207, 234, 1);
  background-size: 50%, cover;
  margin: 0;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>
