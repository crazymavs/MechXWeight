<?php
function get_label_config($conn, $data)
{
    $company_id = 1; // Assuming a single company for now
    $label_configs = [];

    $sql = "SELECT label_id, table_name, column_name, label_name FROM label_mapping WHERE company_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $company_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $label_configs[] = $row;
        }

        $stmt->close();
    } else {
        $responses = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare query"];
        echo json_encode($responses);
        return;
    }

    $responses = ['status' => true, 'data' => $label_configs];
    echo json_encode($responses);
}
