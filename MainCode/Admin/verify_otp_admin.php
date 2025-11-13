<?php
$servername = "fdb1034.awardspace.net";
$username = "4698762_simpelsi";
$password = "katasandi123";
$dbname = "4698762_simpelsi";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents('php://input'));

// Validasi input
if (empty($data->email) || empty($data->otp)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Email dan OTP wajib diisi.']);
    exit();
}

if (!preg_match('/^\d{4}$/', $data->otp)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'OTP harus 4 digit angka.']);
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}

// ✅ Gunakan UTC secara konsisten
date_default_timezone_set('UTC');
$now_utc = gmdate('Y-m-d H:i:s');

// Cek apakah ada record dengan: email + OTP cocok + belum expired
$stmt = $conn->prepare("
    SELECT id_admin 
    FROM admin 
    WHERE email = ? 
      AND otp = ? 
      AND otp_expires > ?
");
$stmt->bind_param("sss", $data->email, $data->otp, $now_utc);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // ✅ Sukses — HANYA di sini OTP dihapus
    $clear = $conn->prepare("UPDATE admin SET otp = NULL, otp_expires = NULL WHERE email = ?");
    $clear->bind_param("s", $data->email);
    $clear->execute();
    $clear->close();
    
    $response = ['status' => 'success', 'message' => 'Login berhasil.'];
} else {
    // ❌ Gagal — TIDAK ADA perubahan di database. Hanya kirim error.
    $response = ['status' => 'error', 'message' => 'Kode OTP salah.'];
}

$stmt->close();
$conn->close();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>