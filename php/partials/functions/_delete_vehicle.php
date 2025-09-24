<?php
function deleteVehicleById($conn, $data)
{
    $vehicleId = $data['vehicle_id'];
    $sql = "DELETE FROM vehicles WHERE vehicle_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $vehicleId);

        if ($stmt->execute()) {
            $affectedRows = $stmt->affected_rows;
            $stmt->close();

            if ($affectedRows > 0) {
                $response = ['status' => true, 'message' => 'Vehicle deleted successfully'];
            } else {
                $response = ['status' => false, 'message' => 'No vehicle found with the given ID'];
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
