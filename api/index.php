<?php
// Toujours mettre ces en-têtes en haut du fichier, avant toute autre sortie
header("Access-Control-Allow-Origin: http://localhost:4208");  // Permet au frontend d'accéder à l'API
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");  // Permet les méthodes HTTP spécifiées
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");  // Permet les en-têtes utilisés par les requêtes

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Répond à la requête OPTIONS avec un statut 200
    header('HTTP/1.1 200 OK');
    exit(0);  // Fin de la requête OPTIONS
}

require_once '../UserController.php';
require_once '../ProductController.php';
require_once '../UserView.php';
require_once '../ProductView.php';
require_once '../database.php';
require_once '../nettoyage.php';
session_start();

// Récupère l'URI et la méthode HTTP
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Instancie le contrôleur
$productController = new ProductController($database);
$userController = new UserController($database);

//GET pour avoir les produits
if ($method == 'GET' && $uri == '/Labo03/api/produits') {
    header('Content-Type: application/json');
    $produits = $productController->getAllProducts();
    echo json_encode($produits);
    exit;
}

//GET pour avoir un produit selon son id
if ($method == 'GET' && preg_match('/^\/Labo03\/api\/produit\/(\d+)$/', $uri, $matches)) {
    $id = $matches[1];

    header('Content-Type: application/json');

    $produit = $productController->getProductById($id);

    if ($produit) {
        echo json_encode($produit);
    } else {
        echo json_encode(["success" => false, "message" => "Produit non trouvé"]);
    }
    exit;
}

//GET pour avoir les tailles des produits
if ($method == 'GET' && preg_match('/^\/Labo03\/api\/taille\/(\d+)$/', $uri, $matches)) {
    $productId = $matches[1];
    header('Content-Type: application/json');

    // Appeler la méthode pour récupérer uniquement les tailles
    $tailles = $productController->getSizesByProductId($productId);

    if ($tailles) {
        echo json_encode($tailles);
    } else {
        echo json_encode(["success" => false, "message" => "Aucune taille trouvée pour ce produit"]);
    }
    exit;
}

//GET pour avoir les produits aléatoires
if ($method == 'GET' && $uri == '/Labo03/api/produitsAle') {
    header('Content-Type: application/json');

    $productId = isset($_GET['id']) ? intval($_GET['id']) : null;

    $produitsAle = $productController->getRandomProducts(3, $productId);

    echo json_encode($produitsAle);
    exit;
}

// GET /api/commande/status
if ($method == 'GET' && $uri == '/Labo03/api/commande/status') {
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo json_encode([
            'success' => true,
            'message' => 'Merci pour votre commande ! Votre commande est en cours de traitement.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Une erreur est survenue. Veuillez réessayer.'
        ]);
    }
    exit();
}

// GET pour afficher le profil d'un utilisateur
if ($method == 'GET' && $uri == '/Labo03/api/user/profil') {

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    $userView = new UserView();
    $userData = $userView->getUserData();

    echo json_encode([
        'success' => true,
        'user' => $userData,
    ]);
    exit();
}

// GET pour avoir le statut de si l'utilisateur est abonné à l'infolettre ou non
if ($method == 'GET' && $uri == '/Labo03/api/infolettre/status') {
    header('Content-Type: application/json');

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    $email = $_SESSION['email'];

    $recupInfolettre = $database->prepare('SELECT * FROM abonnements_infolettre WHERE email = ?');
    $recupInfolettre->execute([$email]);

    $abonnementStatus = $recupInfolettre->rowCount() > 0
        ? "Abonné(e) à l'infolettre"
        : "Non abonné(e) à l'infolettre";

    echo json_encode([
        'success' => true,
        'status' => $abonnementStatus,
    ]);
    exit();
}

//PUT pour modifier un utilisateur
if ($method == 'PUT' && preg_match('/^\/Labo03\/api\/user\/(\d+)$/', $uri, $matches)) {

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    $userId = $matches[1];

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Données invalides ou absentes.']);
        exit();
    }

    $nouveauNom = !empty($data['nom']) ? trim(sanitizeString($data['nom'])) : $_SESSION['name'];
    $nouvelEmail = !empty($data['email']) ? trim(sanitizeString($data['email'])) : $_SESSION['email'];
    $nouveauMotDePasse = !empty($data['password']) ? trim(sanitizeString($data['password'])) : null;

    if (strlen($nouveauNom) < 3) {
        echo json_encode(['success' => false, 'message' => "Le nom doit comporter au moins 3 caractères."]);
        exit();
    }
    if (!empty($nouveauMotDePasse) && strlen($nouveauMotDePasse) < 8) {
        echo json_encode(['success' => false, 'message' => "Le mot de passe doit comporter au moins 8 caractères."]);
        exit();
    }
    if (!empty($nouveauMotDePasse) && strpos($nouveauMotDePasse, ' ') !== false) {
        echo json_encode(['success' => false, 'message' => "Le mot de passe ne doit pas contenir d'espaces."]);
        exit();
    }
    if (!filter_var($nouvelEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => "L'adresse e-mail n'est pas valide."]);
        exit();
    }

    $nouveauMotDePasseHash = $_SESSION['password'];
    if (!empty($nouveauMotDePasse)) {
        $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
    }

    $userController->updateUser($userId, $nouveauNom, $nouvelEmail, $nouveauMotDePasseHash);

    $_SESSION['name'] = $nouveauNom;
    $_SESSION['email'] = $nouvelEmail;

    echo json_encode(['success' => true, 'message' => "Mise à jour réussie."]);
    exit();
}

// DELETE pour supprimer un utilisateur
if ($method == 'DELETE' && preg_match('/^\/Labo03\/api\/user\/(\d+)$/', $uri, $matches)) {

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    $userId = $matches[1];
    if ($userController->deleteUser($userId)) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur de suppression']);
    }
    exit();
}

// POST pour se déconnecter
if ($method === 'POST' && $uri === '/Labo03/api/deconnexion') {

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    session_unset();
    session_destroy();

    echo json_encode([
        'success' => true,
        'message' => 'Déconnexion réussie.'
    ]);
    exit();
}

if ($method == 'POST' && $uri == '/Labo03/api/user') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification si les données ont été correctement envoyées
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Aucune donnée reçue ou format incorrect']);
        exit();
    }

    // Traitement de l'inscription
    $name = sanitizeString($data['name']);
    $email = sanitizeString($data['email']);
    $password = password_hash(sanitizeString($data['password']), PASSWORD_DEFAULT);

    // Vérification et ajout de l'utilisateur
    if ($userController->createUser($name, $email, $password)) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur ajouté']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur d\'ajout']);
    }
    exit();
}


// POST pour la connexion de l'utilisateur
if ($method == 'POST' && $uri == '/Labo03/api/login') {
    header('Content-Type: application/json');

    // Récupérer les données envoyées en POST
    $data = json_decode(file_get_contents('php://input'));

    $email = $data->email ?? '';
    $password = $data->password ?? '';

    if (!$email || !$password) {
        http_response_code(400);
        echo json_encode(['message' => 'Email et mot de passe sont requis.']);
        exit();
    }

    // Rechercher l'utilisateur dans la base de données
    $user = $database->prepare('SELECT * FROM users WHERE email = ?');
    $user->execute([$email]);
    $userData = $user->fetch();

    if ($userData) {
        // Vérifier si le mot de passe est correct
        if (password_verify($password, $userData['password'])) {
            // Si la connexion est réussie, démarrer la session et stocker les informations de l'utilisateur
            session_start();
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['email'] = $userData['email'];

            echo json_encode([
                'message' => 'Connexion réussie.',
                'user' => [
                    'id' => $userData['id'],
                    'email' => $userData['email'],
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Mot de passe incorrect.']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Utilisateur non trouvé.']);
    }

    exit();
}

// POST pour s'inscrire à l'infolettre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/Labo03/api/subscribe-newsletter') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email-newsletter'])) {
        $email = filter_var($data['email-newsletter'], FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = $database->prepare('SELECT * FROM abonnements_infolettre WHERE email = ?');
            $query->execute([$email]);
            $existingUser = $query->fetch();

            if (!$existingUser) {
                $stmt = $database->prepare('INSERT INTO abonnements_infolettre (email) VALUES (?)');
                if ($stmt->execute([$email])) {
                    echo json_encode(["success" => true, "message" => "Merci de vous être abonné à notre infolettre !"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Une erreur est survenue lors de l'inscription. Veuillez réessayer."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Cet e-mail est déjà inscrit à notre infolettre."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Veuillez entrer une adresse e-mail valide."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "L'email est requis."]);
    }
    exit();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(["error" => "Route non trouvée"]);
    exit;
}