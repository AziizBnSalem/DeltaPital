<?php
// Include necessary files
require '../Model/connexion.php';
require '../Controlleur/Ajouter.php';
require '../Controlleur/Modifier.php';
require '../Controlleur/Read.php';
require '../Controlleur/Supprimer.php';

// Initialize the database connection
$db = (new Database())->getConnection();

// Initialize controllers
$ajouterController = new Ajouter($db);
$modifierController = new Modifier($db);
$readController = new Read($db);
$supprimerController = new Supprimer($db);

// Default action
$action = isset($_GET['action']) ? $_GET['action'] : 'read';

// Routing logic based on the action in the URL
switch ($action) {
    case 'add':
        // Call the add action in the Ajouter controller
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Example of POST data, adjust based on your form
            $ajouterController->addClient($data);
        } else {
            // Show add form (e.g., a view for adding a client)
            require '../view/addClientForm.php'; // Your form for adding clients
        }
        break;

    case 'edit':
        // Call the edit action in the Modifier controller
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $data = $_POST; // Example of POST data for editing
            $modifierController->editClient($_GET['id'], $data); // Pass the ID and data
        } else {
            // Show edit form (e.g., a view for editing a client)
            require '../Views/Client/modify.php'; // Your form for editing clients
        }
        break;

    case 'delete':
        // Call the delete action in the Supprimer controller
        if (isset($_GET['id'])) {
            $supprimerController->deleteClient($_GET['id']);
        }
        break;

    case 'read':
    default:
        // Call the read action in the Read controller
        $clients = $readController->getAllClients();
        require '../Views/Dentiste/gestionC.php'; // Your view for listing clients
        break;
}
?>
