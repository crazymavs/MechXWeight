<?php

function saveCompanyData($conn, $data)
{
    try {
        $company_id = $data['company_id'] ?? null;
        $company_name = $data['company_name'] ?? null;
        $company_addr = $data['company_addr'] ?? null;
        $company_phone = $data['company_phone'] ?? null;
        $company_type = $data['company_type'] ?? null;

        if ($company_id) {
            // Update existing company
            $sql = "UPDATE company SET company_name = ?, company_addr = ?, company_phone = ?, company_type = ? WHERE company_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return ['status' => false, 'message' => "Prepare failed: " . $conn->error];
            }
            $stmt->bind_param("ssssi", $company_name, $company_addr, $company_phone, $company_type, $company_id);
            $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();

            return [
                'status' => true,
                'message' => "Company updated successfully",
                'affected_rows' => $affected,
                'company_id' => $company_id
            ];
        } else {
            // Insert new company
            $sql = "INSERT INTO company (company_name, company_addr, company_phone, company_type) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return ['status' => false, 'message' => "Prepare failed: " . $conn->error];
            }
            $stmt->bind_param("ssss", $company_name, $company_addr, $company_phone, $company_type);
            $stmt->execute();
            $insert_id = $stmt->insert_id;
            $stmt->close();

            return [
                'status' => true,
                'message' => "Company inserted successfully",
                'insert_id' => $insert_id
            ];
        }
    } catch (Exception $ex) {
        return ['status' => false, 'message' => $ex->getMessage()];
    }
}
