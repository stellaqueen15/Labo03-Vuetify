<template>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Fenêtre Accueil</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-fenetre">
      <div class="logo-et-caroussel">
        <img
          src="/images/logo_RichRicasso.png"
          alt="Logo Rich Ricasso"
          id="logo"
        />
      </div>
      <main>
        <div class="contenu-main">
          <div class="texte">
            <h2>À propos de Rich Ricasso</h2>
            <p>
              Je suis Rich Ricasso, cravatier et chemisier de renom, passionné
              par l'art de sublimer la mode à travers des pièces intemporelles.
              Mon aventure a commencé avec une vision simple mais ambitieuse :
              fusionner l'élégance classique avec l'esthétique moderne du
              vaporwave et du vaporfashion. <br /><br />

              Après des années à me perfectionner dans l'art de la confection de
              cravates et chemises de luxe, j'ai vu mon style se propager parmi
              les connaisseurs de mode du monde entier. Mes créations,
              caractérisées par des tons pastel tels que le bleu ciel, le rose
              poudré et le violet lavande, ont trouvé leur place dans l'univers
              de l'ultra-luxe, s'adressant à ceux qui recherchent à la fois
              singularité et raffinement.<br /><br />

              Aujourd'hui, je souhaite partager cette passion avec un public
              plus large, en lançant ma boutique en ligne. Cette plateforme est
              dédiée à ma nouvelle gamme d'été en soie unisexe, alliant confort
              et sophistication, tout en restant fidèle à l’esprit de ma marque.
              Mon objectif est de vous offrir un accès direct à des créations à
              la fois modernes et luxueuses, tout en reflétant mon amour pour
              l’esthétique<br /><br />
              vaporwave. Bienvenue dans l’univers de Rich Ricasso, où chaque
              détail compte et où le luxe s’habille de nuances pastel pour
              séduire tous ceux qui osent se démarquer.
            </p>
          </div>
          <div class="caroussel">
            <img class="mySlides" src="/images/tie7.webp" />
            <img class="mySlides" src="/images/tieX.webp" />
            <img class="mySlides" src="/images/tshirt3.webp" />
            <img class="mySlides" src="/images/tshirt2.webp" />
          </div>
        </div>
        <div class="photos-accueil">
          <img src="/images/tshirt2.webp" alt="" id="premier-image-accueil" />
          <img src="/images/tie7.webp" alt="" id="deuxieme-image-accueil" />
          <img src="/images/tshirt6.webp" alt="" id="troisieme-image-accueil" />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup></script>

<style>
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

.contenu-fenetre {
  padding: 20px;
  background: url(/images/Fond-produits.png), url(/images/fond_3.png), no-repeat;
  font-weight: 300;
}

.logo-et-caroussel {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;
  background-color: rgb(141, 28, 186);
  background: url(/images/Fond-produits.png), url(/images/fond_3.png),
    rgb(141, 28, 186) no-repeat;
  border: 2px solid black;
}

#logo {
  width: 20%;
  height: auto;
}

.mySlides {
  display: none;
  border: 5px solid rgb(255, 113, 206);
  box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
  transform: rotate(7deg);
  margin-left: 60px;
  margin-top: 60px;
}

.caroussel img {
  width: 70%;
  height: auto;
}

.contenu-main {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 20px;
}

.texte {
  max-width: 60%;
}

.texte h2 {
  margin: 0 0 10px;
}

.texte p {
  margin: 0;
}

.photos-accueil {
  display: flex;
  justify-content: space-around;
  margin-top: 70px;
}

.photos-accueil img {
  width: 20%;
  height: auto;
  border: 8px solid white;
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
  transition: transform 0.5s ease;
  margin-bottom: 20px;
}

#premier-image-accueil {
  transform: rotate(10deg);
}

#premier-image-accueil:hover {
  transform: rotate(2deg);
}

#deuxieme-image-accueil {
  transform: rotate(-5deg);
}

#deuxieme-image-accueil:hover {
  transform: rotate(3deg);
}

#troisieme-image-accueil {
  transform: rotate(7deg);
}

#troisieme-image-accueil:hover {
  transform: rotate(1deg);
}
</style>
