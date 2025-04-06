<?php
$database = new Database();
$articleManager = new Article($database);

$announcements = $articleManager->getAnnouncements();
echo json_encode($announcements);

$database->close();
?>
