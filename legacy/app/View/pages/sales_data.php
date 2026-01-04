<?php
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$dbname = "chanel_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // This uses your 'orders' table to calculate sales.
    $sql = "
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') as month, 
            SUM(price) as total_sales
        FROM 
            orders 
        GROUP BY 
            month
        ORDER BY 
            month ASC
    ";

    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $chart_data = ['labels' => [], 'sales' => []];
    foreach ($data as $row) {
        $dateObj = DateTime::createFromFormat('!Y-m', $row['month']);
        $chart_data['labels'][] = $dateObj->format('M Y');
        $chart_data['sales'][] = (float)$row['total_sales'];
    }

    echo json_encode($chart_data);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>