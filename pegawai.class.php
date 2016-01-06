<?php
class Pegawai{
	public $nip;
	public $nama_pegawai;
	public $unit_keja;
	public $nama_filephoto;

	function tambah_data(){
		$nama_file = "pegawai.txt";
		$buka_file = fopen($nama_file, "a+");
		$data = $this->nip . "*" . $this->nama_pegawai . "*" . $this->unit_kerja . "*" . $this->file_photo . "#";
		$tulis_file = fwrite($buka_file, $data);
		$pesan = "";
			if ($tulis_file){
				$pesan = "Data berhasil ditambahkan";
			} else {
				$pesan = "Gagal menambahkan data baru";
			}
		return $pesan;
	}
	
	function tampil_data(){
		$nama_file = "pegawai.txt";
		$buka_file = fopen($nama_file, "r");
		$panjang_data = filesize($nama_file);
		$baca_file = fread($buka_file, $panjang_data);
		return $baca_file;
	}
}
?>