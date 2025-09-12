<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getReportsData($conn)
{
    $data = $_POST['tankJSON'];

    if (
        !$data || 
        !isset($data['tankLocation'], $data['startTime'], $data['endTime'], $data['tanks'])
    ) {
        http_response_code(400);
        exit('Invalid input JSON.');
    }

    $tankLocation = mysqli_real_escape_string($conn, $data['tankLocation']);
    $start = mysqli_real_escape_string($conn, $data['startTime']);
    $end = mysqli_real_escape_string($conn, $data['endTime']);

    $results = [];

    foreach ($data['tanks'] as $tank) {
        $tankId = (int)$tank['tank_id'];

        // Prepare FTM subqueries dynamically based on destinations
        $ftmSubqueries = "";
        $ftmCounter = 1;

        foreach ($tank['destinations'] as $dest) {
            $ftmId = (int)$dest['Output_ftm'];
            $source = mysqli_real_escape_string($conn, $dest['source']);
            $alias = 'ftm_f' . $ftmCounter++;

            if ($ftmId > 0 && $source !== "") {
                $ftmSubqueries .= ",
                    (
                        SELECT ROUND(MAX($source) - MIN($source), 2)
                        FROM ftm_live
                        WHERE ftm_id = $ftmId
                        AND `ftm_timestamp` BETWEEN '$start' AND '$end'
                    ) AS $alias
                ";
            } else {
                $ftmSubqueries .= ", 0 AS $alias";
            }
        }

        // Optimized main query (no scalar subqueries in SELECT)
        $sql = "
            SELECT 
                tp.tank_id, 
                tp.tank_code, 
                tp.product_code,

                ROUND(MAX(tl.cum_input) - MIN(tl.cum_input), 2) AS ip_a,
                ROUND(MAX(tl.cum_output) - MIN(tl.cum_output), 2) AS op_c,

                ROUND(init.stock, 2) AS initial_stock_b,
                ROUND(last_val.stock, 2) AS lt_e
                $ftmSubqueries

            FROM tank_live tl
            JOIN tank_profile tp ON tp.tank_id = tl.tank_id

            -- Join latest stock before start time
            JOIN (
                SELECT t1.tank_id, t1.stock
                FROM tank_live t1
                JOIN (
                    SELECT tank_id, MAX(tank_timestamp) AS max_ts
                    FROM tank_live
                    WHERE tank_timestamp <= '$start'
                      AND tank_id = $tankId
                    GROUP BY tank_id
                ) t2
                  ON t1.tank_id = t2.tank_id AND t1.tank_timestamp = t2.max_ts
            ) init ON tl.tank_id = init.tank_id

            -- Join latest stock before end time
            JOIN (
                SELECT t1.tank_id, t1.stock
                FROM tank_live t1
                JOIN (
                    SELECT tank_id, MAX(tank_timestamp) AS max_ts
                    FROM tank_live
                    WHERE tank_timestamp <= '$end'
                      AND tank_id = $tankId
                    GROUP BY tank_id
                ) t2
                  ON t1.tank_id = t2.tank_id AND t1.tank_timestamp = t2.max_ts
            ) last_val ON tl.tank_id = last_val.tank_id

            WHERE tl.tank_id = $tankId
              AND tp.tank_location = '$tankLocation'
              AND tl.tank_timestamp BETWEEN '$start' AND '$end'
            GROUP BY tp.tank_id, tp.tank_code, tp.product_code, init.stock, last_val.stock
            ORDER BY tp.tank_id
        ";

        // Run query and collect results
        $query = mysqli_query($conn, $sql);
        if ($query && mysqli_num_rows($query) > 0) {
            $results[] = mysqli_fetch_assoc($query);
        } else {
            error_log("No data for tank ID $tankId or query failed. SQL: " . mysqli_error($conn));
        }
    }

    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);
}


function getReportsData_old($conn)
{
    $data = $_POST['tankJSON'];

    if (!$data || !isset($data['tankLocation'], $data['startTime'], $data['endTime'], $data['tanks'])) {
        http_response_code(400);
        exit('Invalid input JSON.');
    }

    $tankLocation = $data['tankLocation'];
    $start = $data['startTime'];
    $end = $data['endTime'];

    $results = [];

    foreach ($data['tanks'] as $tank) {
        $tankId = (int)$tank['tank_id'];

        // Prepare FTM subqueries dynamically based on destinations
        $ftmSubqueries = "";
        $ftmCounter = 1;

        foreach ($tank['destinations'] as $dest) {
            $ftmId = (int)$dest['Output_ftm'];
            $source = mysqli_real_escape_string($conn, $dest['source']);
            $alias = 'ftm_f' . $ftmCounter++;

            if ($ftmId > 0 && $source !== "") {
                $ftmSubqueries .= ",
                    (
                        SELECT ROUND(MAX($source) - MIN($source), 2)
                        FROM ftm_live
                        WHERE ftm_id = $ftmId
                        AND `ftm_timestamp` BETWEEN '$start' AND '$end'
                    ) AS $alias
                ";
            } else {
                $ftmSubqueries .= ", 0 AS $alias";
            }
        }

        // Main query per tank
        $sql = "
            SELECT 
                tp.tank_id, 
                tp.tank_code, 
                tp.product_code,

                ROUND(MAX(tl.cum_input) - MIN(tl.cum_input), 2) AS ip_a,

                (
                    SELECT ROUND(stock, 2)
                    FROM tank_live 
                    WHERE tank_id = $tankId
                    AND `tank_timestamp` <= '$start'
                    ORDER BY `tank_timestamp` DESC
                    LIMIT 1
                ) AS initial_stock_b,

                ROUND(MAX(tl.cum_output) - MIN(tl.cum_output), 2) AS op_c,

                (
                    SELECT ROUND(stock, 2)
                    FROM tank_live 
                    WHERE tank_id = $tankId
                    AND `tank_timestamp` <= '$end'
                    ORDER BY `tank_timestamp` DESC
                    LIMIT 1
                ) AS lt_e
                $ftmSubqueries

            FROM tank_live tl
            JOIN tank_profile tp ON tp.tank_id = tl.tank_id
            WHERE tl.tank_id = $tankId
              AND tp.tank_location = '$tankLocation'
              AND tl.tank_timestamp BETWEEN '$start' AND '$end'
            GROUP BY tl.tank_id
            ORDER BY tl.tank_id
        ";
// exit($sql);
        // Run query and collect results
        $query = mysqli_query($conn, $sql);
        if ($query && mysqli_num_rows($query) > 0) {
            $results[] = mysqli_fetch_assoc($query);
        } else {
            error_log("No data for tank ID $tankId or query failed.");
        }
    }

    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);
}


function getReportsData_old($conn)
{
    // 1. Read and decode incoming JSON
    // $payload = file_get_contents('php://input');
    // $data = json_decode($payload, true);
    $data = $_POST['tankJSON'];

    if (!$data || !isset($data['tankLocation'], $data['startTime'], $data['endTime'], $data['tanks'])) {
        http_response_code(400);
        exit('Invalid input JSON.');
    }

    $tankLocation = $data['tankLocation'];
    $start = $data['startTime'];
    $end = $data['endTime'];

    // 2. Connect to MySQL

    $results = [];

    // 3. Loop through each tank
    foreach ($data['tanks'] as $tank) {
        $tankId = (int)$tank['tank_id'];
        $ftmIds = array_map('intval', $tank['Output_ftm']);
        $ftmIds = array_pad($ftmIds, 3, 0); // pad to always have 3 ftms
        $cumulativeFiled = $tank['source'];

        // 4. Build SQL query
        $select = "
            SELECT 
                tp.tank_id, 
                tp.tank_code, 
                tp.product_code,

                ROUND(MAX(tl.cum_input) - MIN(tl.cum_input), 2) AS ip_a,

                (
                    SELECT ROUND(stock, 2)
                    FROM tank_live 
                    WHERE tank_id = $tankId
                    AND `tank_timestamp` <= '$start'
                    ORDER BY `tank_timestamp` DESC
                    LIMIT 1
                ) AS initial_stock_b,

                ROUND(MAX(tl.cum_output) - MIN(tl.cum_output), 2) AS op_c,

                (
                    SELECT ROUND(volume, 2)
                    FROM tank_live 
                    WHERE tank_id = $tankId
                    AND `tank_timestamp` <= '$end'
                    ORDER BY `tank_timestamp` DESC
                    LIMIT 1
                ) AS lt_e
        ";

        // 5. Add ftm_f1, ftm_f2, ftm_f3
        for ($i = 0; $i < 3; $i++) {
            $ftmId = $ftmIds[$i];
            $alias = 'ftm_f' . ($i + 1);

            if ($ftmId > 0) {
                $select .= ",
                    (
                        SELECT ROUND(MAX($cumulativeFiled) - MIN($cumulativeFiled), 2)
                        FROM ftm_live
                        WHERE ftm_id = $ftmId
                        AND `ftm_timestamp` BETWEEN '$start' AND '$end'
                    ) AS $alias
                ";
            } else {
                $select .= ", 0 AS $alias";
            }
        }

        // 6. Finalize query
        $sql = $select . "
            FROM tank_live tl
            JOIN tank_profile tp ON tp.tank_id = tl.tank_id
            WHERE tl.tank_id = $tankId
              AND tp.tank_location = '$tankLocation'
              AND tl.tank_timestamp BETWEEN '$start' AND '$end'
            GROUP BY tl.tank_id
            ORDER BY tl.tank_id
        ";

        // exit($sql);

        // 7. Execute
        $query = mysqli_query($conn, $sql);
        if ($query && mysqli_num_rows($query) > 0) {
            $results[] = mysqli_fetch_assoc($query);
        } else {
            error_log("No data for tank ID $tankId or query failed.");
        }
    }

    // 8. Return results as JSON
    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);
}

function getAllTanksData($conn)
{
    $start = $_POST['startTime'] ?? null;
    $end = $_POST['endTime'] ?? null;

    if (!$start || !$end) {
        http_response_code(400);
        echo json_encode(["error" => "Missing startTime or endTime"]);
        return;
    }

    $stmt = $conn->prepare("
    SELECT 
    tl.tank_id,
    ROUND(MAX(tl.cum_input) - MIN(tl.cum_input), 2) AS ip_a,
    ROUND(MAX(tl.cum_output) - MIN(tl.cum_output), 2) AS op_c,
    ROUND(init.stock, 2) AS initial_stock_b,
    ROUND(last_val.volume, 2) AS lt_e,
    ROUND(last_val.tank_level, 2) AS lt_e_cm
FROM tank_live tl
JOIN (
    -- Get the latest row before or at start time for each tank
    SELECT t1.tank_id, t1.stock
    FROM tank_live t1
    JOIN (
        SELECT tank_id, MAX(tank_timestamp) AS max_ts
        FROM tank_live
        WHERE tank_timestamp <= ?
          AND tank_id IN (1,2,3,4,5,6,7,8,9,10,11,12)
        GROUP BY tank_id
    ) t2
      ON t1.tank_id = t2.tank_id AND t1.tank_timestamp = t2.max_ts
) init ON tl.tank_id = init.tank_id
JOIN (
    -- Get the latest row before or at end time for each tank
    SELECT t1.tank_id, t1.volume, t1.tank_level
    FROM tank_live t1
    JOIN (
        SELECT tank_id, MAX(tank_timestamp) AS max_ts
        FROM tank_live
        WHERE tank_timestamp <= ?
          AND tank_id IN (1,2,3,4,5,6,7,8,9,10,11,12)
        GROUP BY tank_id
    ) t2
      ON t1.tank_id = t2.tank_id AND t1.tank_timestamp = t2.max_ts
) last_val ON tl.tank_id = last_val.tank_id
WHERE tl.tank_id IN (1,2,3,4,5,6,7,8,9,10,11,12)
  AND tl.tank_timestamp BETWEEN ? AND ?
GROUP BY tl.tank_id, init.stock, last_val.volume, last_val.tank_level;

    ");

    // $stmt21 = $conn->prepare("
    //     SELECT tl.tank_id, 
    //     ROUND(MAX(tl.cum_input) - MIN(tl.cum_input), 2) AS ip_a,

    //     (
    //         SELECT ROUND(stock, 2)
    //         FROM tank_live 
    //         WHERE tank_id = tl.tank_id
    //         AND `tank_timestamp` <= ?
    //         ORDER BY `tank_timestamp` DESC
    //         LIMIT 1
    //     ) AS initial_stock_b,

    //     ROUND(MAX(tl.cum_output) - MIN(tl.cum_output), 2) AS op_c,

    //     (
    //         SELECT ROUND(volume, 2)
    //         FROM tank_live 
    //         WHERE tank_id = tl.tank_id
    //         AND `tank_timestamp` <= ?
    //         ORDER BY `tank_timestamp` DESC
    //         LIMIT 1
    //     ) AS lt_e,

    //     (
    //         SELECT ROUND(tank_level, 2)
    //         FROM tank_live 
    //         WHERE tank_id = tl.tank_id
    //         AND `tank_timestamp` <= ?
    //         ORDER BY `tank_timestamp` DESC
    //         LIMIT 1
    //     ) AS lt_e_cm

    //     FROM tank_live tl
    //     WHERE tl.tank_id IN (1,2,3,4,5,6,7,8,9,10,11,12)
    //     AND tl.tank_timestamp BETWEEN ? AND ?
    //     GROUP BY tl.tank_id
    // ");

    $stmt->bind_param('ssss', $start, $end, $start, $end);
    $stmt->execute();
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);
}

function getAllFTM($conn) {
    // $sql = "
    //     SELECT 
    //         fp.ftm_id, 
    //         fp.ftm_name, 
    //         COALESCE(fl.ftm_timestamp, '0000-00-00 00:00:00') AS ftm_timestamp, 
    //         COALESCE(fl.flowrate, 0) AS flowrate,
    //         COALESCE(fl.temp, 0) AS temp,
    //         COALESCE(fl.density, 0) AS density, 
    //         COALESCE(fl.dg, 0) AS dg
    //     FROM 
    //         ftm_profile fp
    //     LEFT JOIN (
    //         SELECT fl1.*
    //         FROM ftm_live fl1
    //         INNER JOIN (
    //             SELECT ftm_id, MAX(ftm_timestamp) AS max_ts
    //             FROM ftm_live
    //             GROUP BY ftm_id
    //         ) fl2 ON fl1.ftm_id = fl2.ftm_id AND fl1.ftm_timestamp = fl2.max_ts
    //     ) fl ON fl.ftm_id = fp.ftm_id
    //     ORDER BY fp.ftm_id DESC
    // ";

    $sql = "SELECT 
    fp.ftm_id, 
    fp.ftm_name, 
    COALESCE(fl.ftm_timestamp, '0000-00-00 00:00:00') AS ftm_timestamp, 
    COALESCE(fl.flowrate, 0) AS flowrate,
    COALESCE(fl2.temp, 0) AS temp,
    COALESCE(fl2.density, 0) AS density, 
    COALESCE(fl2.drive_gain, 0) AS dg
    FROM 
        ftm_profile fp
    LEFT JOIN ftm_live fl ON fl.ftm_id = fp.ftm_id 
                        AND fl.ftm_timestamp = (
                            SELECT MAX(fl_sub.ftm_timestamp) 
                            FROM ftm_live fl_sub 
                            WHERE fl_sub.ftm_id = fp.ftm_id
                        )
    LEFT JOIN ftm_live2 fl2 ON fl2.ftm_id = fp.ftm_id 
                        AND fl2.ftm_timestamp = (
                            SELECT MAX(fl2_sub.ftm_timestamp) 
                            FROM ftm_live2 fl2_sub 
                            WHERE fl2_sub.ftm_id = fp.ftm_id
                        )
    ORDER BY fp.ftm_id DESC;";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}

function getFlowBatches($conn){
    $ftmIds = $_POST['ftm_ids'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    if (empty($ftmIds)) {
        return [];
    }

    // Create placeholders like ?, ?, ? for IN clause
    $placeholders = implode(',', array_fill(0, count($ftmIds), '?'));

    // SQL with placeholders
    $sql = "
        WITH flagged AS (
            SELECT 
                ftm_id,
                ftm_timestamp,
                tot_s1,
                fsts_s1,
                ROW_NUMBER() OVER (PARTITION BY ftm_id ORDER BY ftm_timestamp) AS rn,
                ROW_NUMBER() OVER (PARTITION BY ftm_id, fsts_s1 ORDER BY ftm_timestamp) AS frn
            FROM ftm_live
            WHERE 
                ftm_timestamp BETWEEN ? AND ?
                AND ftm_id IN ($placeholders)
        ),
        flow_groups AS (
            SELECT *,
                   (rn - frn) AS grp
            FROM flagged
            WHERE fsts_s1 = 1
        ),
        grouped_batches AS (
            SELECT 
                ftm_id,
                MIN(ftm_timestamp) AS start_time,
                MAX(ftm_timestamp) AS end_time,
                MIN(tot_s1) AS start_value,
                MAX(tot_s1) AS end_value,
                MAX(tot_s1) - MIN(tot_s1) AS volume
            FROM flow_groups
            GROUP BY ftm_id, grp
            HAVING volume > 0
        )
        SELECT * FROM grouped_batches
        ORDER BY ftm_id, start_time;
    ";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Merge parameters: start_time, end_time, ftm_ids
    $types = str_repeat('s', 2) . str_repeat('i', count($ftmIds));
    $params = array_merge([$startTime, $endTime], $ftmIds);

    // Bind dynamically using call_user_func_array
    $stmt_bind = [];
    $stmt_bind[] = &$types;
    foreach ($params as $key => $value) {
        $stmt_bind[] = &$params[$key];
    }
    call_user_func_array([$stmt, 'bind_param'], $stmt_bind);

    // Execute and fetch
    $stmt->execute();
    $result = $stmt->get_result();

    $batches = [];
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }

    $stmt->close();
    echo json_encode($batches);
}

