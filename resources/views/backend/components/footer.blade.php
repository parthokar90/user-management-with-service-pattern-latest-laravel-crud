  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('backend/dist/js/adminlte.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
     <script>
         Swal.fire({
             icon: 'success',
             text: '{{ session('success') }}',
         });
     </script>
 @endif

 @if (session('error'))
     <script>
         Swal.fire({
             icon: 'error',
             text: '{{ session('error') }}',
         });
     </script>
 @endif