<?php
// Konfigurasi database
$servername = "fdb1034.awardspace.net";
$username = "4698762_simpelsi";
$password = "katasandi123";
$dbname = "4698762_simpelsi";
$SERVER_EMAIL = 'simpelsi@cucidosa.web.id';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$response = [];

$json_data = file_get_contents('php://input');
$data = json_decode($json_data);

if (empty($data->email)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Email wajib diisi.']);
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}

// Cek apakah email admin terdaftar
$stmt = $conn->prepare("SELECT id_admin FROM admin WHERE email = ?");
$stmt->bind_param("s", $data->email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $response = ['status' => 'error', 'message' => 'Email tidak terdaftar sebagai admin.'];
} else {
    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $update = $conn->prepare("UPDATE admin SET otp = ?, otp_expires = ? WHERE email = ?");
    $update->bind_param("sss", $otp, $expires, $data->email);
    if ($update->execute()) {
        // Kirim email
        $to = $data->email;
        $subject = "[SIMPELSI] Kode Verifikasi Admin";
        $message = "Halo Admin,\n\nKode OTP Anda:\n\n    $otp\n\nBerlaku 5 menit. Jangan bagikan ke siapa pun.";
        $headers = "From: SIMPELSI <$SERVER_EMAIL>\r\nReply-To: $SERVER_EMAIL\r\nContent-Type: text/plain; charset=UTF-8";

        if (mail($to, $subject, $message, $headers)) {
            $response = ['status' => 'success', 'message' => 'OTP dikirim ke ' . $data->email];
        } else {
            // Fallback untuk development
            $response = [
                'status' => 'success_dev',
                'message' => 'Gagal kirim email. Gunakan kode berikut:',
                'otp' => $otp
            ];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Gagal menyimpan OTP.'];
    }
    $update->close();
}

$stmt->close();
$conn->close();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>