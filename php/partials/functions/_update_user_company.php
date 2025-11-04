<?php

function updateUserCompany($conn, $userId, $newCompany)
{
    $sql = "UPDATE users SET user_company = ? WHERE user_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return [
            "status" => false,
            "message" => "Prepare failed: " . $conn->error
        ];
    }
    $stmt->bind_param("ii", $newCompany, $userId);
    $exec = $stmt->execute();
    if ($exec) {
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        if ($affectedRows > 0) {
            $userCompany = $newCompany;
            return [
                "status" => true,
                "message" => "User company updated successfully."
            ];
        } else {
            return [
                "status" => false,
                "message" => "No changes made or user not found."
            ];
        }
    } else {
        $stmt->close();
        return [
            "status" => false,
            "message" => "Execute failed: " . $stmt->error
        ];
    }
}
