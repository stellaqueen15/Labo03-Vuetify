<template>
  <div class="fenetre-connexion">
    <div class="barre-connexion">
      <span class="window-title-connexion">Fenêtre Modification</span>
      <div class="boutons-fenetre-connexion">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-connexion">
      <div class="bloc-connexion">
        <h2>Modifier</h2>
        <form action="" method="POST" id="form-modification">
          <label>Nouveau nom</label><br />
          <input
            type="text"
            id="nom"
            name="nom"
            value="<?= $_SESSION['name']; ?>"
          /><br /><br />
          <label>Nouvel email</label><br />
          <input
            type="email"
            id="email"
            name="email"
            value="<?= $_SESSION['email']; ?>"
          /><br /><br />
          <label>Nouveau mot de passe</label><br />
          <input type="password" id="password" name="password" /><br /><br />
          <input type="submit" id="submit" value="Modifier" />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
document.getElementById("submit").addEventListener("click", (event) => {
  event.preventDefault();

  const userId = null;

  const formData = new FormData(document.getElementById("form-modification"));

  const data = {
    nom: formData.get("nom"),
    email: formData.get("email"),
    password: formData.get("password"),
  };

  fetch(`http://localhost:4208/Labo03/api/user/${userId}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Erreur HTTP : ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Réponse du serveur :", data);

      if (data.success) {
        alert(data.message);
        window.location.href = "profil.php";
      } else {
        alert(`Erreur : ${data.message}`);
      }
    })
    .catch((error) => {
      console.error("Erreur lors de la soumission du formulaire :", error);
    });
});
</script>

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
