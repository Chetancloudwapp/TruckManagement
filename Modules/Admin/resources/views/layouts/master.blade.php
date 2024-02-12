
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Truck Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/adminlte.min2167.css?v=3.2.0')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/summernote/summernote-bs4.min.css')}}">

    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center"> <img class="animation__shake" src="{{ asset('public/assets/images/truck.jpg')}}" alt="TruckLogo" height="80" width="80"> </div>
        
        <!-- header code here -->
        @include('admin::layouts.header')

        <!-- sidebar code starts here -->
        @include('admin::layouts.sidebar')

       
        <!-- middlecontent starts here -->
        @yield('content')

        <!-- footer code start here -->
        @include('admin::layouts.footer')
        <aside class="control-sidebar control-sidebar-dark"> </aside>
    </div>

    <!-- important scripts -->
    <script src="{{ asset('public/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('public/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- datatable scripts -->
    <script src="{{ asset('public/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
     
    <!-- Sweet-alert-script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Summernote-script -->
    <script src="{{ asset('public/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
   
    <!-- Include jQuery -->
   
     
    <script src="{{ asset('public/assets/js/adminlte2167.js?v=3.2.0')}}"></script>
    <script src="{{ asset('public/assets/js/demo.js')}}"></script>
    <script src="{{ asset('public/assets/js/pages/dashboard.js')}}"></script>
    <!-- Custom Js File -->
    <script src="{{ asset('public/assets/js/custom.js')}}"></script>

    <script>
        const BaseadminUrl="{{ url('admin') }}"
        $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $('#categories').DataTable();
        $('#category').DataTable();
        $('#officeExpense').DataTable();
        });
    </script>
    <script>
        $('.summernote').summernote({
             tabsize: 2,
             height: 250
         });
    </script>
       {{-- @stack('scripts') --}}
    </body>
    </html>