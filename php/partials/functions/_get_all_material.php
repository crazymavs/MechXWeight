<?php
function getAllMaterials($conn)
{
    $materials = [];

    $sql = "SELECT material_id, material_name, is_active FROM material ORDER BY material_id DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }

        $stmt->close();
    } else {
        throw new Exception("Database query preparation failed: " . $conn->error);
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    echo json_encode(['status' => true, 'data' => $materials]);
}


function getMaterialById($conn, $data)
{
    if (!isset($data['material_id'])) {
        echo json_encode(['status' => false, 'message' => 'Material ID is required']);
        return;
    }

    $material_id = $data['material_id'];
    $material = null;

    $sql = "SELECT material_id, material_name, is_active FROM material WHERE material_id = ? LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $material_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $material = $row;
        }

        $stmt->close();
    } else {
        throw new Exception("Database query preparation failed: " . $conn->error);
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    if ($material) {
        echo json_encode(['status' => true, 'data' => $material]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Material not found']);
    }
}
