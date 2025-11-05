<?php
function deleteMaterialById($conn, $data)
{
    $materialId = $data['material_id'];
    $sql = "DELETE FROM material WHERE material_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $materialId);

        if ($stmt->execute()) {
            $affectedRows = $stmt->affected_rows;
            $stmt->close();

            if ($affectedRows > 0) {
                $response = ['status' => true, 'message' => 'Material deleted successfully'];
            } else {
                $response = ['status' => false, 'message' => 'No material found with the given ID'];
            }
        } else {
            $error = $stmt->error;
            $stmt->close();
            $response = ['status' => false, 'error' => $error];
        }
    } else {
        $response = ['status' => false, 'error' => $conn->error];
    }

    echo json_encode($response);
}
