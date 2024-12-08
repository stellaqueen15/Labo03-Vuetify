<template>
  <v-app>
    <v-main>
      <router-view />
    </v-main>
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
  background: url(images/fond_2.png),
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

.fenetre {
  width: 1200px;
  border: 2px solid black;
  background: linear-gradient(
    360deg,
    rgb(255, 113, 206) 0%,
    rgb(214, 94, 241) 100%
  );
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
  margin: 20px auto;
}

.barre {
  background-color: rgb(141, 28, 186);
  color: white;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.boutons-fenetre {
  display: flex;
  gap: 10px;
}

.boutons-fenetre span {
  cursor: pointer;
  background-color: rgb(1, 205, 254);
  color: rgb(0, 0, 0);
  padding: 2px 8px;
  border-radius: 4px;
}

.boutons-fenetre span:hover {
  background-color: rgb(74, 217, 253);
}
</style>
