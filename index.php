<?php
	//memasukkan class pegawai dalam file index.php
	include "pegawai.class.php";

	$txtNIP = isset($_POST["txtNIP"]) ? $_POST["txtNIP"] : "";
	$txtNamaPegawai = isset($_POST["txtNamaPegawai"]) ? $_POST["txtNamaPegawai"] : "";
	$cmbUnitKerja = isset($_POST["cmbUnitKerja"]) ? $_POST["cmbUnitKerja"] : "";
	$foto = isset($_POST["photo"]) ? $_POST["photo"] : "";
	$cmdSimpan = isset($_POST["cmdSimpan"]) ? $_POST["cmdSimpan"] : "";
	//mengecek apakah data sudah terisi
	if ($cmdSimpan == "Simpan" && !empty($txtNIP) && !empty($txtNamaPegawai) && !empty($cmbUnitKerja) && !empty($foto) )
	{
		$tambah_pegawai = new Pegawai();
		$tambah_pegawai->nip = $txtNIP;
		$tambah_pegawai->nama_pegawai = $txtNamaPegawai;
		$tambah_pegawai->unit_kerja = $cmbUnitKerja;
		$tambah_pegawai->file_photo = $foto;
		$tambah_data = $tambah_pegawai->tambah_data();
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Data Pegawai</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<form action="index.php" method="post">
			<h3>Input Data Pegawai</h3>
			<div class="baris">
				<span class="label">Nomor Induk Pegawai</span>
				<span class="komponen-form"><input type="text" name="txtNIP"/></span>
			</div>
			<div class="baris">
				<span class="label">Nama Pegawai</span>
				<span class="komponen-form"><input type="text" name="txtNamaPegawai" /></span>
			</div>
			<div class="baris">
				<span class="label">Unit Kerja</span>
				<span class="komponen-form">
					<select name="cmbUnitKerja">
						<option value="Administrasi">Administrasi</option>
						<option value="Penangung Jawab">Penangung Jawab</option>
					</select>
				</span>
			</div>

			<div class="baris">
				<span class="label">Upload Gambar</span>
				<span class="komponen-form"><input type="file" name="photo" /></span>
			</div>

			<div class="baris">
				<span class="label">&nbsp;</span>
				<span class="komponen-form"><button type="submit" name="cmdSimpan" value="Simpan">Simpan</button></span>
			</div>
		</form>

		<hr />
		<h3>Daftar Pegawai</h3>

		<?php
		//menyalin foto ke direktori yang di tuju
		if(isset($_FILES['photo'])){
			//membuat penanganan eror menggunakan fungsi array
		      $errors= array();
		      //Dekripsi File gambar : nama, ukuran file dan tipe file
		      $file_name = $_FILES['photo']['name'];
		      $file_size =$_FILES['photo']['size'];
		      $file_tmp =$_FILES['photo']['tmp_name'];
		      $file_type=$_FILES['photo']['type'];
		      $file_ext=strtolower(end(explode('.',$_FILES['photo']['name'])));
		      //ekstensi file yang diizinkan
		      $expensions= array("jpeg","jpg","png","JPG");
		      //m
		      if(in_array($file_ext,$expensions)=== false){
		         $errors[]="tipe file tidak di dukung, mohon pilih tipe file JPEG or PNG file.";
		      }
		      
		      if($file_size > 2097152){
		         $errors[]='ukuran file harus kurang dari 2 MB';
		      }
		      //jika eror tidak ditemukan
		      if(empty($errors)==true){
		      	//memindahkan dan menyalin gambar ke di tektori images
		         move_uploaded_file($file_tmp,"images/".$file_name);
		         echo "Success";
		      }
		      else{
		      	//mencetak eror
		         print_r($errors);
		      }
		   }

		   	//membuat list pegawai dengan mengambil class pegawai
			$list_pegawai = new Pegawai();
			//memngambil method tampil data pada class pegawai
			$data = $list_pegawai->tampil_data();
			//jika data masih kosong
			if ($data == ""){
				echo "Belum Ada Data";
			} else 
			{
				echo "<table>";
				echo "<tr>";
				echo "<th>No</td>";
				echo "<th>NIP</td>";
				echo "<th>Nama Pegawai</td>";
				echo "<th>Unit Kerja</td>";
				echo "<th>Photo</td>";
				echo "</tr>";
				//memcah string tiap 1 baris data pegawai
				$data_per_baris = explode("#", $data);
				$jumlah_baris = count($data_per_baris);
				$no=1;
				for ($i=0; $i<=$jumlah_baris-2; $i++)
				{
					//memecah kolom tiap baris data pegawai
					$data_per_kolom = explode("*", $data_per_baris[$i]);
					echo "<tr>";
					echo "<td>".$no."</td>";
					echo "<td>".$data_per_kolom[0]."</td>";
					echo "<td>".$data_per_kolom[1]."</td>";
					echo "<td>".$data_per_kolom[2]."</td>";
					echo "<td><img src='images/".$data_per_kolom[3]."'width='50' height='50'/></td>";
					$no=$no+1;
					echo "</tr>";
				}
				echo "</table>";
			}
		?>
		<script>
		//membuat fungsi allert
		alert("<?php echo $tambah_data; ?>");
		</script>
	</body>
</html>