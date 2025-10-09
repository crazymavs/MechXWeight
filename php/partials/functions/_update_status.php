<?php

function updateRecordStatus($conn, $data)
{
    if (
        empty($data['ticketNo']) ||
        !is_array($data['ticketNo']) ||
        count($data['ticketNo']) === 0 ||
        empty($data['new_status'])
    ) {
        echo json_encode(['status' => false, 'message' => 'ticketNo (array) and new_status are required']);
        return;
    }

    $ticketNumbers = isset($data['ticketNo']) ? $data['ticketNo'] : null;
    $newStatus = isset($data['new_status']) ? $data['new_status'] : null;

    // Prepare IN clause with correct number of placeholders
    $placeholders = implode(',', array_fill(0, count($ticketNumbers), '?'));

    $sql = "UPDATE weighing_record SET status = ? WHERE ticket_no IN ($placeholders)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Types: first is 'i' for newStatus, then 'i' repeated for each ticket number
        $types = str_repeat('i', 1 + count($ticketNumbers));
        $params = array_merge([$newStatus], $ticketNumbers);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => true, 'message' => 'Status updated successfully']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No record updated (IDs may not exist)']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Execution failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => 'Preparation failed: ' . $conn->error]);
    }
}
