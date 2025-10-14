<?php
require("config.php");
require("lock.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $row = $DB->getRowById('whatsapp_logs', $id);
    
    if ($row) {
        $DB->delete('whatsapp_logs', $id);
        $_SESSION['msg'] = "WhatsApp log deleted successfully.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['msg'] = "WhatsApp log not found.";
        $_SESSION['msg_type'] = "danger";
    }
} else {
    $_SESSION['msg'] = "Invalid ID.";
    $_SESSION['msg_type'] = "danger";
}

header("Location: manage-whatsapp.php");
exit();
?>
