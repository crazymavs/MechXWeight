<?php

function getCompanyData($conn, $data)
{
    $company_id = $data['company_id'];
    try {
        if ($company_id) {
            // Fetch single company by ID
            $sql = "SELECT * FROM company WHERE company_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $company_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $company = $result->fetch_assoc();
            $stmt->close();

            if ($company) {
                echo json_encode(['status' => true, 'data' => $company]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Company not found']);
            }
        } else {
            // Fetch all companies
            $sql = "SELECT * FROM company";
            $result = $conn->query($sql);
            if (!$result) {
                throw new Exception("Query failed: " . $conn->error);
            }
            $companies = [];
            while ($row = $result->fetch_assoc()) {
                $companies[] = $row;
            }
            echo json_encode(['status' => true, 'data' => $companies]);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
    }
}
