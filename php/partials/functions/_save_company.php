<?php

function saveCompanyData($conn, $data, $file = null)
{
    try {
        $company_id = $data['company_id'] ?? null;
        $company_name = $data['company_name'] ?? null;
        $company_addr = $data['company_addr'] ?? null;
        $company_phone = $data['company_phone'] ?? null;
        $company_type = $data['company_type'] ?? null;

        // Handle file upload if $file is provided and has no error
        if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
            include_once 'php/partials/global/_config.php';
            $uploadDir = 'uploads/company_logos/';  // Adjust path as needed
            var_dump(__DIR__);
            var_dump($uploadDir);
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = basename($file['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileExt, $allowedExt)) {
                echo json_encode(['status' => false, 'message' => "Invalid logo file type."]);
                return;
            }

            // Generate a unique filename to avoid conflicts
            $newFileName = uniqid('logo_', true) . '.' . $fileExt;
            $targetFile = $uploadDir . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo json_encode(['status' => false, 'message' => "Failed to upload logo image."]);
                return;
            }

            // Store relative path or filename to save in DB
            $logo_path = $targetFile;
            var_dump($logo_path);
        }
        if ($company_id) {
            // Update existing company
            if ($logo_path) {
                $sql = "UPDATE company SET company_name = ?, company_addr = ?, company_phone = ?, company_type = ?, company_logo = ? WHERE company_id = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    echo json_encode(['status' => false, 'message' => "Prepare failed: " . $conn->error]);
                    return;
                }
                $stmt->bind_param("sssssi", $company_name, $company_addr, $company_phone, $company_type, $logo_path, $company_id);
            } else {
                $sql = "UPDATE company SET company_name = ?, company_addr = ?, company_phone = ?, company_type = ? WHERE company_id = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    echo json_encode(['status' => false, 'message' => "Prepare failed: " . $conn->error]);
                    return;
                }
                $stmt->bind_param("ssssi", $company_name, $company_addr, $company_phone, $company_type, $company_id);
            }

            $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();

            echo json_encode([
                'status' => true,
                'message' => "Company updated successfully",
                'affected_rows' => $affected,
                'company_id' => $company_id
            ]);
        } else {
            $user_id = $data['user_id'] ?? null;

            // Insert new company (include logo if uploaded)
            if ($logo_path) {
                $sql = "INSERT INTO company (company_name, company_addr, company_phone, company_type, company_logo) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    echo json_encode(['status' => false, 'message' => "Prepare failed: " . $conn->error]);
                    return;
                }
                $stmt->bind_param("sssss", $company_name, $company_addr, $company_phone, $company_type, $logo_path);
            } else {
                $sql = "INSERT INTO company (company_name, company_addr, company_phone, company_type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    echo json_encode(['status' => false, 'message' => "Prepare failed: " . $conn->error]);
                    return;
                }
                $stmt->bind_param("ssss", $company_name, $company_addr, $company_phone, $company_type);
            }

            $stmt->execute();
            $insert_id = $stmt->insert_id;
            $stmt->close();

            // Update user's company
            include_once 'php/partials/functions/_update_user_company.php';
            $status = updateUserCompany($conn, $user_id, $insert_id);

            if (!$status['status']) {
                echo json_encode([
                    'status' => false,
                    'message' => "Company created but failed to update user company: " . $status['message'],
                    'insert_id' => $insert_id
                ]);
                return;
            }

            echo json_encode([
                'status' => true,
                'message' => "Company inserted successfully",
                'insert_id' => $insert_id
            ]);
        }
    } catch (Exception $ex) {
        echo json_encode(['status' => false, 'message' => $ex->getMessage()]);
    }
}
