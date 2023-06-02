@extends('support.template')
@section('title','Dashboard')

@section('style')
<style>
    /*  */
</style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row" id="show_all_employees">
            {{-- Kontent --}}
        </div>
    </div>
</section>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script>
        //CSRF TOKEN PADA HEADER
        //Script ini wajib krn kita butuh csrf token setiap kali mengirim request post, patch, put dan delete ke server
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(function() {

            // fetch all employees ajax request
            fetchAllEmployees();

            function fetchAllEmployees() {
                $.ajax({
                url: '{{ route('support-fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                }
                });
            }

        });

    </script>
@endsection
