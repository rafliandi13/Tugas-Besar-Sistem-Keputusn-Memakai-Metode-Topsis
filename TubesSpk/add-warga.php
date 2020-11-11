<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1, 2)); ?>

<?php
$errors = array();
$sukses = false;

$no_ktp = (isset($_POST['no_ktp'])) ? trim($_POST['no_ktp']) : '';
$nama = (isset($_POST['nama'])) ? trim($_POST['nama']) : '';
$kriteria = (isset($_POST['kriteria'])) ? $_POST['kriteria'] : array();


if(isset($_POST['submit'])):	
	
	// Validasi
	if(!$no_ktp) {
		$errors[] = 'Nomor warga tidak boleh kosong';
	}	
	
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		
		$handle = $pdo->prepare('INSERT INTO warga (no_ktp, nama, tanggal_input) VALUES (:no_ktp, :nama, :tanggal_input)');
		$handle->execute( array(
			'no_ktp' => $no_ktp,
			'nama' => $nama,
			'tanggal_input' => date('Y-m-d')
		) );
		$sukses = "warga no. <strong>{$no_ktp}</strong> berhasil dimasukkan.";
		$id_warga = $pdo->lastInsertId();
		
		// Jika ada kriteria yang diinputkan:
		if(!empty($kriteria)):
			foreach($kriteria as $id_kriteria => $nilai):
				$handle = $pdo->prepare('INSERT INTO nilai_warga (id_warga, id_kriteria, nilai) VALUES (:id_warga, :id_kriteria, :nilai)');
				$handle->execute( array(
					'id_warga' => $id_warga,
					'id_kriteria' => $id_kriteria,
					'nilai' =>$nilai
				) );
			endforeach;
		endif;
		
		redirect_to('show-warga.php?status=sukses-baru');		
		
	endif;

endif;
?>

<?php
$judul_page = 'Tambah Warga';
require_once('template-parts/header.php');
?>

	<div class="main-content-row">
	<div class="container clearfix">
	
		<?php include_once('template-parts/sidebar-warga.php'); ?>
	
		<div class="main-content the-content">
			<h1>Tambah Warga</h1>
			
			<?php if(!empty($errors)): ?>
			
				<div class="msg-box warning-box">
					<p><strong>Error:</strong></p>
					<ul>
						<?php foreach($errors as $error): ?>
							<li><?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				
			<?php endif; ?>			
			
			
				<form action="add-warga.php" method="post">
					<div class="field-wrap clearfix">					
						<label>Nomor KTP <span class="red">*</span></label>
						<input type="text" name="no_ktp" value="<?php echo $no_ktp; ?>">
					</div>					
					<div class="field-wrap clearfix">					
						<label>Nama</label>
						<textarea name="nama" cols="30" rows="2"><?php echo $nama; ?></textarea>
					</div>			
					
					<h3>Nilai Kriteria</h3>
					<?php
					$query = $pdo->prepare('SELECT id_kriteria, nama, ada_pilihan FROM kriteria ORDER BY urutan_order ASC');			
					$query->execute();
					// menampilkan berupa nama field
					$query->setFetchMode(PDO::FETCH_ASSOC);
					
					if($query->rowCount() > 0):
					
						while($kriteria = $query->fetch()):							
						?>
						
							<div class="field-wrap clearfix">					
								<label><?php echo $kriteria['nama']; ?></label>
								<?php if(!$kriteria['ada_pilihan']): ?>
									<input type="number" step="0.001" name="kriteria[<?php echo $kriteria['id_kriteria']; ?>]">								
								<?php else: ?>
									
									<select name="kriteria[<?php echo $kriteria['id_kriteria']; ?>]">
										<option value="0">-- Pilih Variabel --</option>
										<?php
										$query3 = $pdo->prepare('SELECT * FROM pilihan_kriteria WHERE id_kriteria = :id_kriteria ORDER BY urutan_order ASC');			
										$query3->execute(array(
											'id_kriteria' => $kriteria['id_kriteria']
										));
										// menampilkan berupa nama field
										$query3->setFetchMode(PDO::FETCH_ASSOC);
										if($query3->rowCount() > 0): while($hasl = $query3->fetch()):
										?>
											<option value="<?php echo $hasl['nilai']; ?>"><?php echo $hasl['nama']; ?></option>
										<?php
										endwhile; endif;
										?>
									</select>
									
								<?php endif; ?>
							</div>	
						
						<?php
						endwhile;
						
					else:					
						echo '<p>Kriteria masih kosong.</p>';						
					endif;
					?>
					
					<div class="field-wrap clearfix">
						<button type="submit" name="submit" value="submit" class="button">Tambah Warga</button>
					</div>
				</form>
					
			
		</div>
	
	</div><!-- .container -->
	</div><!-- .main-content-row -->


<?php
require_once('template-parts/footer.php');