<template>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Fenêtre Catalogue</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <form action="catalogue.php" method="get" class="form-catalogue">
      <div>
        <label for="type">Type de produit :</label>
        <select id="type" name="type">
          <option value="">Tous</option>
          <option value="cravate">Cravate</option>
          <option value="chemise">Chemise</option>
        </select>
      </div>

      <div>
        <label for="couleur">Couleur :</label>
        <select id="couleur" name="couleur">
          <option value="">Toutes</option>
          <option value="bleu">Bleu</option>
          <option value="violet">Violet</option>
          <option value="rose">Rose</option>
          <option value="mauve">Mauve</option>
          <option value="blanc">Blanc</option>
        </select>
      </div>

      <div>
        <label for="taille">Taille :</label>
        <select id="taille" name="taille">
          <option value="">Toutes</option>
          <option value="Unique">Unique</option>
          <option value="44-56">44-56</option>
        </select>
      </div>

      <div>
        <label for="prix_min">Prix minimum :</label>
        <input
          type="number"
          id="prix_min"
          name="prix_min"
          min="0"
          step="0.01"
        />
      </div>

      <div>
        <label for="prix_max">Prix maximum :</label>
        <input
          type="number"
          id="prix_max"
          name="prix_max"
          min="0"
          step="0.01"
        />
      </div>

      <div>
        <input type="submit" value="Filtrer" class="sora-font" />
      </div>
    </form>
    <div class="product-container">
      <div id="product-list"></div>
    </div>
  </div>
</template>

<script setup>
const app = document.getElementById("product-list");

const url = "/Labo03/api/produits";

fetch(url)
  .then((response) => {
    if (!response.ok) {
      throw new Error(`Erreur HTTP : ${response.status}`);
    }

    return response.text().then((text) => {
      try {
        return JSON.parse(text);
      } catch (error) {
        throw new Error("La réponse n'est pas un JSON valide");
      }
    });
  })
  .then((products) => {
    let html = '<div class="product-container">';
    products.forEach((product) => {
      html += `
        <div class="product-card">
          <a href="product_detail.php?id=${product.id}">
            <img src="${product.image}" alt="${product.name}" class="product-image" />
            <h3>${product.name}</h3>
            <p>${product.prix} €</p>
          </a>
        </div>
      `;
    });
    html += "</div>";

    app.innerHTML = html;
  })
  .catch((error) => {
    console.error("Erreur:", error);
    app.innerHTML = `<p>Une erreur est survenue : ${error.message}</p>`;
  });
</script>

<style scoped>
.product-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  margin: 0 auto;
  max-width: 1200px;
}

.product-card > a {
  color: black;
  text-decoration: none;
}

.product-card {
  background: url(images/Fond-produits.png), url(images/fond_3.png),
    linear-gradient(180deg, rgb(223, 70, 218) 0%, rgb(194, 57, 224) 100%)
      no-repeat;
  background-size: 100%, cover;
  background-position: center, -190px 0px;
  margin: 0;
  border: 2px solid #000000;
  padding: 20px;
  margin: 10px;
  width: 220px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  overflow: hidden;
  text-align: center;
}

.product-card p {
  font-weight: 500;
}

.product-card:hover {
  transform: scale(1.05);
  cursor: pointer;
}

.product-image {
  width: 100%;
  height: auto;
  border-radius: 0px;
}

.form-catalogue {
  background-color: rgb(141, 28, 186);
  display: flex;
  justify-content: space-between;
  font-weight: 500;
  color: rgb(1, 205, 254);
  padding: 10px;
}

.form-catalogue input[type="number"] {
  width: 60px;
}

.form-catalogue input[type="submit"] {
  border: 1px solid black;
  background-color: rgb(1, 205, 254);
  font-weight: 600;
}

.form-catalogue input[type="submit"]:hover {
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
  cursor: pointer;
}
</style>
