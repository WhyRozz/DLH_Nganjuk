<?php
$servername = "fdb1034.awardspace.net";
$username = "4698762_simpelsi";
$password = "katasandi123";
$dbname = "4698762_simpelsi";

header('Content-Type: application/json');

$response = [];

$json_data = file_get_contents('php://input');
$data = json_decode($json_data);

if (empty($data->email) || empty($data->otp)) {
    echo json_encode(['status' => 'error', 'message' => 'Email dan OTP wajib diisi.']);
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}

$stmt = $conn->prepare("SELECT id_admin FROM admin WHERE email = ? AND otp = ? AND otp_expires > NOW()");
$stmt->bind_param("ss", $data->email, $data->otp);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    // Bersihkan OTP
    $clear = $conn->prepare("UPDATE admin SET otp = NULL, otp_expires = NULL WHERE email = ?");
    $clear->bind_param("s", $data->email);
    $clear->execute();
    $clear->close();
    $response = ['status' => 'success', 'message' => 'OTP valid.'];
} else {
    $response = ['status' => 'error', 'message' => 'OTP salah atau kadaluarsa.'];
}

$stmt->close();
$conn->close();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>