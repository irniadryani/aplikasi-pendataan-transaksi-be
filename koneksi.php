<?php
$dbconn = pg_connect("host=127.0.0.1 dbname=produksi user=postgres password=irinn1601");

if($dbconn) {
    echo 'Koneksi berhasil';
} else {
    echo 'Terjadi kesalahan saat mencoba untuk terhubung';
}
?>
