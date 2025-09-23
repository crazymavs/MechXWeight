<?php
function insertVehicle($conn, $data)
{
    $sql = "INSERT INTO vehicles (vehicle_owner, vehicle_number, vehicle_created_at, vehicle_status, vehicle_weight) 
            VALUES (?, ?, ?, ?, ?)";
    $created_at = date('Y-m-d H:i:s');
    $status = 1;
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssis",
            $data['owner_name'],
            $data['vehicle_number'],
            $created_at, // Should be in 'YYYY-MM-DD HH:MM:SS' format
            $status,
            $data['vehicle_weight']
        );

        if ($stmt->execute()) {
            $insertedId = $stmt->insert_id;
            $stmt->close();
            $response = ['status' => true, 'id' => $insertedId];
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
