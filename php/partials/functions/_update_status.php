<?php

function updateRecordStatus($conn, $data)
{
    if (empty($data['ticketNo']) || empty($data['new_status'])) {
        echo json_encode(['status' => false, 'message' => 'record_id and new_status are required']);
        return;
    }

    $ticket_no = isset($data['ticketNo']) ? $data['ticketNo'] : null;
    $newStatus = isset($data['new_status']) ? $data['new_status'] : null;
    $sql = "UPDATE weighing_record SET status = ? WHERE ticket_no = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $newStatus, $ticket_no);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => true, 'message' => 'Status updated successfully']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No record updated (ID may not exist)']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Execution failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => 'Preparation failed: ' . $conn->error]);
    }
}
