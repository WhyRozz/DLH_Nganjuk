<?php
// Konfigurasi
$servername = "fdb1034.awardspace.net";
$username = "4698762_simpelsi";
$password = "katasandi123";
$dbname = "4698762_simpelsi";
$SERVER_EMAIL = 'simpelsi@cucidosa.web.id';

// Header
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Input
$json_data = file_get_contents('php://input');
$data = json_decode($json_data);

if (empty($data->email)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Email wajib diisi.']);
    exit();
}

// Koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal.']);
    exit();
}

// Cek email admin
$stmt = $conn->prepare("SELECT id_admin FROM admin WHERE email = ?");
$stmt->bind_param("s", $data->email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $response = ['status' => 'error', 'message' => 'Email tidak terdaftar sebagai admin.'];
} else {
    // ✅ Generate 4-digit OTP
    $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    
    // ✅ Gunakan UTC untuk konsistensi
    date_default_timezone_set('UTC');
    $expires = gmdate('Y-m-d H:i:s', strtotime('+5 minutes')); // +5 menit dari sekarang (UTC)

    // Simpan ke DB
    $update = $conn->prepare("UPDATE admin SET otp = ?, otp_expires = ? WHERE email = ?");
    $update->bind_param("sss", $otp, $expires, $data->email);
    
    if ($update->execute()) {
        // Kirim email
        $to = $data->email;
        $subject = "[SIMPELSI] Kode Verifikasi Admin (4 Digit)";
        $message = "Halo Admin,\n\nKode OTP Anda:\n\n    $otp\n\nBerlaku 5 menit. Bisa digunakan berulang kali selama belum kadaluarsa.";
        $headers = "From: SIMPELSI <$SERVER_EMAIL>\r\nReply-To: $SERVER_EMAIL\r\nContent-Type: text/plain; charset=UTF-8";

        if (mail($to, $subject, $message, $headers)) {
            $response = ['status' => 'success', 'message' => 'OTP 4 digit dikirim ke ' . $data->email];
        } else {
            // 🔧 Mode development — tampilkan OTP (hapus di production!)
            $response = [
                'status' => 'success_dev',
                'message' => '[DEV] Email gagal. Gunakan kode berikut (5 menit):',
                'otp' => $otp
            ];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Gagal menyimpan OTP ke database.'];
    }
    $update->close();
}

$stmt->close();
$conn->close();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>