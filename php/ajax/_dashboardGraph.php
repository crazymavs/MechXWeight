<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function getDashboardGraphData($conn) {
    
    $fromTime = isset($_POST['from']) ? $_POST['fromTime'] : null;
    $toTime = isset($_POST['to']) ? $_POST['toTime'] : null;

// if (!$fromTime || !$toTime) {
//     http_response_code(400);
//     echo json_encode(["error" => "Missing from or to parameters"]);
//     exit;
// }

// Query to get latest tank_live per tank_id within the time range
// $sql = "SELECT 
//             t.tank_id,
//             CONCAT(t.tank_code, ' - ', t.tank_name) AS tank_label,
//             COALESCE(l.tank_level, 0) AS tank_level,
//             COALESCE(l.volume, 0) AS volume,
//             COALESCE(l.current_totalizer_input, 0) AS input,
//             COALESCE(l.current_totalizer_output, 0) AS output
//         FROM tank_profile t
//         LEFT JOIN (
//             SELECT l1.*
//             FROM tank_live l1
//             INNER JOIN (
//                 SELECT tank_id, MAX(tank_timestamp) AS latest
//                 FROM tank_live
//                 WHERE tank_timestamp BETWEEN ? AND ?
//                 GROUP BY tank_id
//             ) l2 ON l1.tank_id = l2.tank_id AND l1.tank_timestamp = l2.latest
//         ) l ON t.tank_id = l.tank_id
//         ORDER BY t.tank_id";

// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ss", $fromTime, $toTime);







// $sql = "
//     SELECT 
//         t.tank_id,
//         CONCAT(t.tank_code, ' - ', t.tank_name) AS tank_label,
//         COALESCE(l.tank_level, 0) AS tank_level,
//         COALESCE(l.volume, 0) AS volume
//     FROM tank_profile t
//     LEFT JOIN (
//         SELECT l1.*
//         FROM tank_live l1
//         INNER JOIN (
//             SELECT tank_id, MAX(tank_timestamp) AS latest
//             FROM tank_live
//             WHERE tank_timestamp BETWEEN ? AND ?
//             GROUP BY tank_id
//         ) l2 ON l1.tank_id = l2.tank_id AND l1.tank_timestamp = l2.latest
//     ) l ON t.tank_id = l.tank_id
//     ORDER BY t.tank_id
// ";

$sql = "
    SELECT 
        t.tank_id,
        t.tank_code AS tank_label,
        COALESCE(l.tank_level, 0) AS tank_level,
        COALESCE(l.volume, 0) AS volume
    FROM tank_profile t
    LEFT JOIN (
        SELECT l1.*
        FROM tank_live l1
        INNER JOIN (
            SELECT tank_id, MAX(tank_timestamp) AS latest
            FROM tank_live
            WHERE tank_timestamp BETWEEN ? AND ?
            GROUP BY tank_id
        ) l2 ON l1.tank_id = l2.tank_id AND l1.tank_timestamp = l2.latest
    ) l ON t.tank_id = l.tank_id
    ORDER BY t.tank_id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $fromTime, $toTime);
$stmt->execute();
$result = $stmt->get_result();

$data = [
    'tank_ids' => [],
    'tank_level' => [],
    'volume' => []
];

while ($row = $result->fetch_assoc()) {
    $data['tank_ids'][] = $row['tank_label'];
    $data['tank_level'][] = (float) $row['tank_level'];
    $data['volume'][] = (float) $row['volume'] * -1;
}

echo json_encode($data);


// $sql = "SELECT t.tank_id, CONCAT(t.tank_code, ' - ', t.tank_name) AS tank_label, COALESCE(l.tank_level, 0) AS tank_level, COALESCE(l.volume, 0) AS volume, COALESCE(l.current_totalizer_input, 0) AS input, COALESCE(l.current_totalizer_output, 0) AS output FROM tank_profile t LEFT JOIN ( SELECT l1.* FROM tank_live l1 INNER JOIN ( SELECT tank_id, MAX(tank_timestamp) AS latest FROM tank_live WHERE tank_timestamp BETWEEN '2025-02-01' AND '2025-06-29' GROUP BY tank_id ) l2 ON l1.tank_id = l2.tank_id AND l1.tank_timestamp = l2.latest ) l ON t.tank_id = l.tank_id ORDER BY t.tank_id;";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $result = $stmt->get_result();

// $data = [
//     'tank_ids' => [],
//     'tank_level' => [],
//     'volume' => [],
//     'input' => [],
//     'output' => []
// ];

// while ($row = $result->fetch_assoc()) {
//     $data['tank_ids'][] = $row['tank_label'];
//     $data['tank_level'][] = (float) $row['tank_level'];
//     $data['volume'][] = (float) $row['volume'];
//     $data['input'][] = (float) $row['input'];
//     $data['output'][] = (float) $row['output'];
// }

// header('Content-Type: application/json');
// echo json_encode($data);



}







?>
