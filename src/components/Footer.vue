<template>
  <div id="newsletter-section">
    <h3>Abonnez-vous à notre infolettre !</h3>
    <form action="" method="POST">
      <label for="email-newsletter">Votre adresse e-mail :</label>
      <input
        type="email"
        id="email-newsletter"
        name="email-newsletter"
        placeholder="Entrez votre email"
        required
      />
      <input type="submit" value="S'abonner" class="sora-font" />
    </form>
  </div>
  <p>Site créé par Brenda et Tarek - Copyright</p>
</template>

<style>
#newsletter-section,
footer {
  font-weight: bold;
  text-align: center;
}

#newsletter-section {
  height: 95px;
  background: linear-gradient(-90deg, rgb(1, 205, 254), rgb(175, 233, 255));
  width: 700px;
  border-radius: 80px;
  border: 2px solid black;
}

#newsletter-section input[type="email"] {
  border: none;
  width: 200px;
  height: 22px;
  margin-right: 10px;
}

#newsletter-section input[type="email"]::placeholder {
  color: rgb(2, 159, 199);
  opacity: 0.4;
}

#newsletter-section input[type="submit"] {
  background: linear-gradient(90deg, rgb(255, 113, 206), rgb(214, 94, 241));
  font-size: 18px;
  font-weight: 400;
  color: white;
  border: 1px solid black;
}

#newsletter-section input[type="submit"]:hover {
  cursor: pointer;
  background: linear-gradient(90deg, rgb(214, 94, 241), rgb(255, 113, 206));
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

/*ÉCRAN POUR TABLETTE*/
@media (min-width: 768px) and (max-width: 1024px) {
  .fenetre {
    width: 90%;
  }
}
</style>
