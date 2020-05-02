<footer class="main-footer">
	<strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
	All rights reserved.
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 3.0.4
	</div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script type="text/javascript" src="<?= base_url() ?>assets/js/croppie.js"></script>
<script>
	$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- ChartJS -->
<script src="<?=base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=base_url()?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=base_url()?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=base_url()?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=base_url()?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=base_url()?>assets/plugins/moment/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url()?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=base_url()?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url()?>assets/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>assets/js/demo.js"></script>
<script>
  // Alert auto hidden
  $(".alert").delay(2000).slideUp(500, function() {
    $(this).alert('close');
  });

  $('.dateMe').datetimepicker({
    language: 'pt-BR'
  });

  $('#reservation').daterangepicker();

  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(document).ready(function(){
    var arrayLabel = $.parseJSON('<?= js_array($months) ?>');
    var dataChart = $.parseJSON('<?= js_array($dataChart) ?>');
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: arrayLabel,
        datasets: [{
          label: 'reservation',
          data: dataChart,
          backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
          ],
          borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
        responsive: true
      }
    });
  })

  var w = $(window).width(),

  h = $(window).height();



  $image_crop = $('#image_demo').croppie({

    enableExif: true,

    viewport: {

      width:300,

      height:400,

      type:'square'

    },

    boundary:{

      width:w,

      height:h

    },

    enableResize: true,

    enableOrientation: true,

    mouseWheelZoom: 'ctrl'

  });



  $('#upload_image').on('change', function(){

    var reader = new FileReader();

    reader.onload = function (event) {

      $image_crop.croppie('bind', {

        url: event.target.result

      }).then(function(){

        console.log('jQuery bind complete');

      });

    }

    reader.readAsDataURL(this.files[0]);

    $('#uploadimageModal').modal('show');

  });



  $('.crop_image').click(function(event){

    $image_crop.croppie('result', {

      type: 'canvas',

      size: 'viewport'

    }).then(function(response){

      var judul = $('input[name="judul"]').val();

      $.ajax({

        url:"{{url('api/image/cropped')}}",

        type: "POST",

        data:{"image": response, "nama" : judul},

        success:function(data)

        {

          var obj = $.parseJSON(data);

          $('#uploadimageModal').modal('hide');

          $('#uploadedimage').html('<img src="{{url("images/konten/spot/header")}}/'+obj+'">');

          var input = '<input type="hidden" name="headerName">';

          $('#formHidden').append(input);

          $('input[name="headerName"]').val(obj);

        }

      });

    })

  });
//Date picker
$('.datepicker').datepicker({
  autoclose: true
})
</script>
</body>
</html>