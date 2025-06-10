<?php
require_once __DIR__ . '/../Model/ContactInfo.php';
require_once __DIR__ . '/../View/ContactView.php';

class ContactController {
    private $contactInfo;
    
    public function __construct() {
        $this->contactInfo = new ContactInfo();
    }

    public function showContactPage() {
        $view = new ContactView();
        $view->render($this->contactInfo);
    }
}

// Handle contact page request
if (isset($_GET['action']) && $_GET['action'] === 'contact') {
    $controller = new ContactController();
    $controller->showContactPage();
}
?> 