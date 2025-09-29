<?php
function getAllVehicles($conn)
{
    $vehicles = [];

    $sql = "SELECT vehicle_id, vehicle_owner, vehicle_number, vehicle_created_at, vehicle_status, vehicle_weight FROM vehicles ORDER BY vehicle_created_at DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }

        $stmt->close();
    } else {
        throw new Exception("Database query preparation failed: " . $conn->error);
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    echo json_encode(['status' => true, 'data' => $vehicles]);
}

function getVehicleById($conn, $data)
{
    if (!isset($data['vehicle_id'])) {
        echo json_encode(['status' => false, 'message' => 'Vehicle ID is required']);
        return;
    }

    $vehicle_id = $data['vehicle_id'];
    $vehicle = null;

    $sql = "SELECT vehicle_id, vehicle_owner, vehicle_number, vehicle_created_at, vehicle_status, vehicle_weight FROM vehicles WHERE vehicle_id = ? LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $vehicle = $row;
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    if ($vehicle) {
        echo json_encode(['status' => true, 'data' => $vehicle]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Vehicle not found']);
    }
}
