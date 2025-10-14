<?php
require("config.php");
require("lock.php");

if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']); 

    if (is_numeric($id)) { 
        $id = intval($id);

        // Start transaction
        $DB->DB->beginTransaction();

        try {
        
            $sql_gallery = "DELETE FROM `emergencycase_images` WHERE emergencycase_id = :id";
            $stmt_gallery = $DB->DB->prepare($sql_gallery);
            $stmt_gallery->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_gallery->execute();


            $sql_documents = "DELETE FROM `documents` WHERE emergencycase_id = :id";
            $stmt_timelines = $DB->DB->prepare($sql_documents);
            $stmt_timelines->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_timelines->execute();

    
            $sql_program = "DELETE FROM `emergencycase` WHERE id = :id";
            $stmt_program = $DB->DB->prepare($sql_program);
            $stmt_program->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_program->execute();

        
            $DB->DB->commit();

            $_SESSION['message'] = "Emergency Case and related data deleted successfully.";
            $_SESSION['error'] = "success";

        } catch (Exception $e) {
            $DB->DB->rollBack();

            $_SESSION['message'] = "Error deleting program: " . $e->getMessage();
            $_SESSION['error'] = "error";
        }

    } else {
        $_SESSION['message'] = "Invalid ID format.";
        $_SESSION['error'] = "error";
    }
} else {
    $_SESSION['message'] = "ID not provided.";
    $_SESSION['error'] = "error";
}
header('Location: manage-emergencycase.php');
exit();
?>