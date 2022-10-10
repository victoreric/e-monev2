<?php
include 'menuA.php';
include '../link.php';
?>

<div>
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="index"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="#">Grafik</a></li>
  </ul>
</div>


<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Capaian Seksi</h6>
        </div>
        <div class="card-body" style="color:black">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="dataTable1" width="100%" cellspacing="0">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>Seksi</th>
                            <th>Kegiatan</th>
                            <th>Realisasi</th>
                            <th>Tidak Realisasi</th>
                        </tr>
                    </thead> 
                    <?php
                        $no=1;
                        $totalKegiatan=0;
                        $totalKegiatanRea=0;
                        $totalKegiatanTidakRea=0;
                        // mendapatkan nama seksi
                            $query="SELECT nama_seksi, kd_seksi FROM seksi";
                            $sql=mysqli_query($conn,$query);
                            while($hasil=mysqli_fetch_array($sql))
                        {    
                            $kd_seksi=$hasil['kd_seksi']
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $hasil['nama_seksi'];?></td>

                                <?php
                                    // mendaptkan jumlah kegiatan setiap seksi
                                    $query1="SELECT count(*) as jum FROM kegiatan WHERE kd_seksi='$kd_seksi'";
                                    $sql1=mysqli_query($conn,$query1);
                                    $data1=mysqli_fetch_array($sql1);
                                    $jumlah=$data1['jum'];
                                    $totalKegiatan+=$jumlah;

                                    // mendapatkan jumlah kegiatan terealisasi dari masing-masing  seksi
                                    $query2="SELECT count(*) as jumRea FROM kegiatan WHERE kd_seksi='$kd_seksi' AND realisasi='Realisasi'";
                                    $sql2=mysqli_query($conn,$query2);
                                    $data2=mysqli_fetch_array($sql2);
                                    $jumlahRealisasi=$data2['jumRea'];
                                    $totalKegiatanRea+=$jumlahRealisasi;

                                    // mendapatkan jumlah kegiatan tidak terealisasi dari masing-masing seksi
                                    $query3="SELECT count(*) as jumRea FROM kegiatan WHERE kd_seksi='$kd_seksi' AND realisasi='Tidak Realisasi'";
                                    $sql3=mysqli_query($conn,$query3);
                                    $data3=mysqli_fetch_array($sql3);
                                    $jumlahTidakRealisasi=$data3['jumRea'];
                                    $totalKegiatanTidakRea+=$jumlahTidakRealisasi;


                                ?>
                            <td><?php echo $jumlah ?></td>
                            <td><?php echo $jumlahRealisasi ?></td>
                            <td><?php echo $jumlahTidakRealisasi ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <!-- endCard -->
    </div>


    <!-- card graph -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Capaian Seksi</h6>
        </div>
        <div class="card-body" style="color:black">
        
                    <div class="card-body">
                        <div id="mygraph"></div>
                    </div>
             
        </div>
    </div>
    <!-- endCardGraph -->

    <!-- Area Chart -->
<script>
  var chart1; 
  $(document).ready(function() {
     chart1 = new Highcharts.Chart({
     chart: {
     renderTo: 'mygraph',
     type: 'column'
    //  type: 'line'
    //  type: 'bar'
    
     },   
     title: {
     text: 'Capaian Seksi'
     },
     xAxis: {
     categories: ['Total Kegiatan', 'Realisasi', 'Tidak Realisasi']
     },
     yAxis: {
     title: {
        text: 'Kegiatan'
     }
     },
	 series:             
     [
     
    <?php  

		$query="SELECT nama_seksi, kd_seksi FROM seksi";
        $sql=mysqli_query($conn,$query);
        while($hasil=mysqli_fetch_array($sql)){    
            $kd_seksi=$hasil['kd_seksi'];

        $query1="SELECT count(*) as jum FROM kegiatan WHERE kd_seksi='$kd_seksi'";
        $sql1=mysqli_query($conn,$query1);
        $data1=mysqli_fetch_array($sql1);
        $jumlah=$data1['jum'];
        // $totalKegiatan+=$jumlah;

        $query2="SELECT count(*) as jumRea FROM kegiatan WHERE kd_seksi='$kd_seksi' AND realisasi='Realisasi'";
        $sql2=mysqli_query($conn,$query2);
        $data2=mysqli_fetch_array($sql2);
        $jumlahRealisasi=$data2['jumRea'];
        // $totalKegiatanRea+=$jumlahRealisasi;

        $query3="SELECT count(*) as jumRea FROM kegiatan WHERE kd_seksi='$kd_seksi' AND realisasi='Tidak Realisasi'";
        $sql3=mysqli_query($conn,$query3);
        $data3=mysqli_fetch_array($sql3);
        $jumlahTidakRealisasi=$data3['jumRea'];
      ?>
        {
		name: "<?php  echo $hasil['nama_seksi']; ?>",
         data: [<?php  echo $jumlah; ?>, <?php echo $jumlahRealisasi.",". $jumlahTidakRealisasi ?>]
	   },

    <?php  }  ?>
	]
     });
     }); 
 </script>


<!-- endContainerFluid -->
</div>



<?php
include '../footer.php';
?>