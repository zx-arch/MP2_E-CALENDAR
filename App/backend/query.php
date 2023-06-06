<?php

session_start();
require_once 'koneksi.php';

class MethodQuery {

    public function __construct() {
        $this->error_date = "";
    }

    public function getAll($account) {
		global $mysqli;
		$query="SELECT * FROM activity WHERE username='$account'";
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
        $getharimulai = (int) explode('-',$data['tgl_mulai'])[2];

        $gettahunselesai = (int) explode('-',$data['tgl_selesai'])[0];
        $getbulanselesai = (int) str_replace("0","",explode('-',$data['tgl_selesai'])[1]);
        $gethariselesai = (int) str_replace("0","",explode('-',$data['tgl_selesai'])[2]);
            

        if ($gettahunselesai < $gettahunmulai) {
            $this->error_date .= "* Tahun dari tanggal selesai lebih besar dari tahun mulai<br>";
        } else {
            if ($getbulanselesai < $getbulanmulai) {
            $this->error_date .= "* Bulan dari tanggal selesai lebih besar dari tahun mulai<br>";
            } 
            if ($gethariselesai < $getharimulai) {
                $this->error_date .= "* Hari dari tanggal selesai lebih besar dari tahun mulai";
            }
        }
        return $this->error_date;
    }

    public function insertNewData($data, $user) {
        global $mysqli;
        $durasi = (int) $data['durasi_jam']*60 + (int) $data['durasi_menit'];
        if ($this->error_date == "") {
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
        }
    }
}