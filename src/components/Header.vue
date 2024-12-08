<template>
  <menu>
    <a href="/">Accueil</a>
    <div class="header-separateur"></div>
    <a href="/catalogue">Catalogue</a>
    <div class="header-separateur"></div>

    <a href="/profil">Profil</a>
    <div class="header-separateur"></div>
    <a href="/panier"
      ><img src="./images/chariot-de-chariot.png" alt="" style="width: 36px"
    /></a>
    <div class="header-separateur"></div>
    <a href="deconnexion.php">Déconnexion</a>
    <a href="/inscription">S'identifier</a>
  </menu>
</template>

<script></script>

<style>
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
