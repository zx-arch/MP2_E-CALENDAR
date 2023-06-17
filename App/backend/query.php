<?php

session_start();
require_once 'koneksi.php';

class MethodQuery {

    public function __construct() {
        $this->error_date = "";
        $this->error_image = "";
    }

    public function getAll($account) {
		global $mysqli;
		$query="SELECT * FROM activity WHERE username='$account'";
		$data=array();
		$result=$mysqli->query($query);
        return $result;
	}

    public function getDataByDate($account, $tgl) {
		global $mysqli;
		$query="SELECT * FROM activity WHERE username='$account' and tgl_mulai LIKE '$tgl%'";
		$data=array();
		$result=$mysqli->query($query);
        return $result;
	}

    public function getDataById($account, $id) {
		global $mysqli;
		$query="SELECT * FROM activity WHERE username='$account' and id='$id'";
		$data=array();
		$result=$mysqli->query($query);
        return $result;
    }

    public function checkAccount($username) {
		global $mysqli;
		$query="SELECT * FROM users WHERE username='$username'";
		$data=array();
		$result=$mysqli->query($query);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($username,$password) {
		global $mysqli;
		$query="SELECT * FROM users WHERE username='$username'";
		$data=array();
		$result=$mysqli->query($query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $verify = password_verify($password, $row['password']); 
            if ($verify) {
                return true;
            } else { 
                return false;
            } 
        }
        return false;
    }

    public function insertNewUser($data) {
        global $mysqli;
        $encrypt_pass = password_hash($data['password'], PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
        $query = "INSERT INTO users(username,`password`) VALUES ('".$data['username']."','".$encrypt_pass."')";
        return $mysqli->query($query);
    }

    public function validateDate($data) {
        $gettahunmulai = (int) explode('-',$data['tgl_mulai'])[0];
        $getbulanmulai = (int) explode('-',$data['tgl_mulai'])[1];
        $gettglmulai = (int) explode('-',$data['tgl_mulai'])[2];

        $gettahunselesai = (int) explode('-',$data['tgl_selesai'])[0];
        $getbulanselesai = (int) str_replace("0","",explode('-',$data['tgl_selesai'])[1]);
        $gettglselesai = (int) explode('-',$data['tgl_selesai'])[2];
        if ($gettglmulai < (int) date('d') and $getbulanmulai == (int) date('m')) {
            $this->error_date .= "* Tanggal mulai minimal tanggal hari ini<br>";
        }
        if ($gettglselesai < $gettglmulai) {
            $this->error_date .= "* Tanggal selesai lebih besar dari tanggal mulai<br>";
        }
        if ($gettglselesai < (int) date('d') and $getbulanmulai == (int) date('m')) {
            $this->error_date .= "* Tanggal selesai minimal tanggal hari ini<br>";
        } else {
            if ($gettahunselesai < $gettahunmulai) {
                $this->error_date .= "* Tahun dari tanggal selesai lebih besar dari tahun mulai<br>";
            } else {
                if ($getbulanselesai < $getbulanmulai) {
                $this->error_date .= "* Bulan dari tanggal selesai lebih besar dari tahun mulai<br>";
                }
            }
        }

        return $this->error_date;
    }

    public function validateImage($gbr) {
        if (!empty($gbr)) {

            if ($gbr['gambar']['type'] != 'image/jpeg' and $gbr['gambar']['type'] != 'image/jpg' and $gbr['gambar']['type'] != 'image/png') {
                $this->error_image .= "* File Gambar Harus PNG atau JPG<br>";
            }

            if ($gbr['gambar']['size'] > 512000) {
                $this->error_image .= "* Ukuran Gambar Maksimal 512 KB<br>";
            }
            return $this->error_image;
        }
    }

    public function insertNewData($data, $gbr, $user) {
        global $mysqli;
        $durasi = (int) $data['durasi_jam']*60 + (int) $data['durasi_menit'];

        if ($this->error_date == "") {
            if (empty($gbr)) {
                $query = 
                    "INSERT INTO activity(nama,tgl_mulai,tgl_selesai,`level`,durasi,lokasi,username) VALUES (
                    '".$data['nama']."',
                    '".$data['tgl_mulai']."',
                    '".$data['tgl_selesai']."',
                    '".$data['level']."',
                    '$durasi',
                    '".$data['lokasi']."',
                    '$user'
                )";
                return $mysqli->query($query);
            } else {

                $namagbr = explode('.',$gbr['gambar']['name'])[0];
                $ekstensigbr = explode('.',$gbr['gambar']['name'])[count(explode('.',$gbr['gambar']['name']))-1];

                if ($gbr['gambar']['type'] == 'image/jpeg' or $gbr['gambar']['type'] == 'image/jpg' or $gbr['gambar']['type'] == 'image/png') {
                    if ($gbr['gambar']['size'] <= 512000) {
                        $uniqname = $namagbr.bin2hex(random_bytes(16)).'-'.rand().'.'.$ekstensigbr;

                        if ($data['level'] == 'biasa') {
                            $data['level'] = "Biasa";
                        } elseif($data['level'] == 'sedang')  {
                            $data['level'] = 'Sedang';
                        } elseif($data['level'] == 'sangat_penting') {
                            $data['level'] = 'Sangat penting';
                        }

                        
                        move_uploaded_file($gbr['gambar']['tmp_name'],'App/img/'.$uniqname);
                        $query = 
                            "INSERT INTO activity(nama,tgl_mulai,tgl_selesai,`level`,durasi,lokasi,gambar,username) VALUES (
                                '".$data['nama']."',
                                '".$data['tgl_mulai']."',
                                '".$data['tgl_selesai']."',
                                '".$data['level']."',
                                '$durasi',
                                '".$data['lokasi']."',
                                '$uniqname',
                                '$user'
                            )";
                        return $mysqli->query($query);
                    }
                }
            }
        }
    }
    
    public function updateData($data, $gbr)
    {
        global $mysqli;
        $id = $data['id'];
        $nama = $data['nama'];
        $tgl_mulai = $data['tgl_mulai'];
        $tgl_selesai = $data['tgl_selesai'];
        $level = $data['level'];
        $durasi = (int) $data['durasi_jam']*60 + (int) $data['durasi_menit'];
        $durasi_menit = $data['durasi_menit'];
        $lokasi = $data['lokasi'];

        // update ke data base 
        $query = "UPDATE `activity` SET 
        `nama` = '$nama', 
        `tgl_mulai` = '$tgl_mulai',  
        `tgl_selesai` = '$tgl_selesai', 
        `level` = '$level', 
        `durasi` = '$durasi',   
        `lokasi` = '$lokasi'
        WHERE `activity`.`id` = $id";
        $mysqli->query($query);

        // update dengan gambar 
        if (!empty($gbr)) {
            $namagbr = explode('.',$gbr['gambar']['name'])[0];
            $ekstensigbr = explode('.',$gbr['gambar']['name'])[count(explode('.',$gbr['gambar']['name']))-1];

            if ($gbr['gambar']['type'] == 'image/jpeg' or $gbr['gambar']['type'] == 'image/jpg' or $gbr['gambar']['type'] == 'image/png') {
                if ($gbr['gambar']['size'] <= 512000) {
                    $uniqname = $namagbr.bin2hex(random_bytes(16)).'-'.rand().'.'.$ekstensigbr;
                    
                    move_uploaded_file($gbr['gambar']['tmp_name'],'App/img/'.$uniqname);

                    $query = "UPDATE `activity` SET 
                    `nama` = '$nama', 
                    `tgl_mulai` = '$tgl_mulai',  
                    `tgl_selesai` = '$tgl_selesai', 
                    `level` = '$level', 
                    `durasi` = '$durasi',  
                    `gambar` = '$uniqname',  
                    `lokasi` = '$lokasi'
                    WHERE `activity`.`id` = $id";

                    return $mysqli->query($query);
                }
            }
        }

    }

    public function delete($data) {
        global $mysqli;
        $query = 'DELETE FROM `activity` WHERE `activity`.`id` = '.$data.'';
        return $mysqli->query($query);
    }

    public function getRentangTanggal($account) {
        global $mysqli;
        $query = "SELECT tgl_mulai, tgl_selesai FROM activity WHERE username='$account'";
        $result = $mysqli->query($query);
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tgl_mulai = explode('-', $row['tgl_mulai']);
                $tgl_selesai = explode('-', $row['tgl_selesai']);
                $data[] = [
                    'tahun' => (int) $tgl_mulai[0],
                    'bulan' => (int) $tgl_mulai[1] - 1, // Mengurangi 1 karena index bulan dimulai dari 0
                    'tgl_mulai' => (int) $tgl_mulai[2],
                    'tgl_selesai' => (int) $tgl_selesai[2]
                ];
            }
        }
        return $data;
    }

}