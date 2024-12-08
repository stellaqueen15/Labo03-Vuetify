<template>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Fenêtre Profil</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-profil"></div>
  </div>
</template>

<style>
contenu-profil {
  background: url(images/Fond-produits.png), url(images/fond_3.png);
  background-position: center, 0px 0px;
  height: 195px;
  text-align: center;
}

.nom-user {
  font-size: 30px;
  font-weight: 500;
  margin-top: 0;
}

.email-user,
.abonne_infolettre {
  font-size: 20px;
  font-weight: 300;
  margin-top: 0;
}

.liens-modification > a {
  text-decoration: none;
  font-weight: 300;
  background: linear-gradient(
    -90deg,
    rgb(1, 205, 254) 0%,
    rgb(145, 233, 255) 100%
  );
  padding: 3px;
  border: 1px solid black;
  margin-left: 10px;
  color: black;
}

.liens-modification > a:hover {
  background: linear-gradient(
    -90deg,
    rgb(0, 190, 237) 0%,
    rgb(117, 215, 240) 100%
  );
}</style>