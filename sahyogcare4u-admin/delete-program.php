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
        
        


            $sql_timelines = "DELETE FROM `subprogram_timelines` WHERE subprogram_id = :id";
            $stmt_timelines = $DB->DB->prepare($sql_timelines);
            $stmt_timelines->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_timelines->execute();

    
            $sql_program = "DELETE FROM `programs` WHERE id = :id";
            $stmt_program = $DB->DB->prepare($sql_program);
            $stmt_program->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_program->execute();

            // Agar sab kuch sahi chala, to commit karo
            $DB->DB->commit();

            $_SESSION['message'] = "Program and related data deleted successfully.";
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

header('Location: manage-program.php');
exit();
?>