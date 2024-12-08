<template>
  <div class="fenetre-connexion">
    <div class="barre-connexion">
      <span class="titre-fenetre-connexion">Fenêtre Inscription</span>
      <div class="boutons-fenetre-connexion">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-connexion">
      <div class="bloc-connexion">
        <h2>Inscription</h2>
        <form action="" method="post">
          <label>Nom</label><br />
          <input type="text" id="nom" name="nom" required /><br /><br />
          <label>Email</label><br />
          <input type="email" id="email" name="email" required /><br /><br />
          <label>Mot de passe</label><br />
          <input
            type="password"
            id="password"
            name="password"
            required
          /><br /><br />
          <input type="submit" value="S'inscrire" />
        </form>
        <a href="/connexion" class="connecter">Se connecter</a>
      </div>
    </div>
  </div>
</template>

<style>
.contenu-connexion {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.fenetre-connexion {
  width: 400px;
  border: 2px solid black;
  background: linear-gradient(
    360deg,
    rgb(255, 113, 206) 0%,
    rgb(214, 94, 241) 100%
  );
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
  margin: 20px auto;
  text-align: center;
}

.barre-connexion {
  background-color: rgb(141, 28, 186);
  color: white;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.boutons-fenetre-connexion {
  display: flex;
  gap: 10px;
}

.boutons-fenetre-connexion span {
  cursor: pointer;
  background-color: rgb(1, 205, 254);
  color: rgb(0, 0, 0);
  padding: 2px 8px;
  border-radius: 4px;
}

.boutons-fenetre-connexion span:hover {
  background-color: rgb(74, 217, 253);
}

.bloc-connexion input[type="email"],
.bloc-connexion input[type="text"],
.bloc-connexion input[type="password"] {
  border: none;
  width: 200px;
  height: 22px;
}

.bloc-connexion input[type="email"]:focus,
.bloc-connexion input[type="text"]:focus,
.bloc-connexion input[type="password"]:focus {
  outline: none;
  border: 2px solid rgb(255, 113, 206);
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

.bloc-connexion input[type="submit"] {
  background-color: rgb(1, 205, 254);
  font-size: 16px;
  font-weight: 400;
  color: white;
  border: 2px solid black;
  margin-bottom: 10px;
}

.bloc-connexion input[type="submit"]:hover {
  cursor: pointer;
  background: linear-gradient(360deg, rgb(1, 205, 254), rgb(45, 185, 241));
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

.bloc-connexion > a {
  text-decoration: none;
  display: block;
  padding: 4px;
  font-weight: 400;
  margin-right: 300px;
  margin-bottom: 10px;
  color: white;
  background-color: rgb(141, 28, 186);
  border: 2px solid black;
}

.bloc-connexion > a:hover {
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

.contenu-connexion {
  background: url(images/Fond-produits.png), url(images/fond_3.png);
  background-position: center, -210px 0px;
}

.connecter {
  margin-left: 40px;
  width: 110px;
}
</style>
