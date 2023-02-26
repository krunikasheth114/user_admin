@extends('layouts.master')
@section('page_title', 'Reports')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">@yield('page_title')</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                    <li class="breadcrumb-item active"></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <div class="card-header-actions">
                                    <div class="row">
                                        <div class="col-4">
                                                <form id="importReport" name="importReport" method="post">
                                                    @csrf
                                                    @if (\Session::has('message'))
                                                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                                                    @endif
            
                                                    <input type="file" name="file" class="form-control" required>
                                                    <br>
                                                    <button class="btn btn-success">Import Report</button>
                                                
                                                </form>
                                        </div>
                                        <div class="col-2">
                                            <a class="btn btn-warning export" id="export" >Export 
                                                report</a>
                                        </div>

                                        <div class="col-6">
                                            <div class="row">
                                            <div class="col-3">
                                                <input type="time" name="time1" value="" class="form-control" id="time1">
                                            </div>
                                            <span>To</span>
                                            <div class="col-3">
                                                <input type="time" name="time2"  value=""class="form-control" id="time2">
                                            </div>
                                            <button type="button" name="filter" id="filter" class="btn btn-primary filter mr-2">Filter</button>
                                            <button type="button" name="reset" id="reset" class="btn btn-primary reset">Reset</button>
                                        </div>
                                            <!--Default date and time picker -->
                                        </div>
                                        <br>
                                        
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="ajax-msg"></div>
                                <div class="table-responsive">
                                    {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
   
@endsection
@push('page_scripts')
    {!! $dataTable->scripts() !!}
    <script>
           $('#importReport').validate({
            rules: {
                // category_name: {
                //     required: true,
                // }

            },
            submitHandler: function(form) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    url: "{{ route('admin.reportImport') }}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        window.location.reload();
                    },
                    error: function(error) {
                        // console.log(error.responseJSON.errors);
                        var i;
                        var res = error.responseJSON.errors;
                        $.each(res, function(key, value) {
                            toastr.error(value);
                        });

                    }

                });
            }
        });
        $('body').on('click', '#export', function() {
                // var ids = $("#report_id").val();
                // console.log(ids);
                var report_ids = new Array();

                $('.report_id:checked').each(function() {
                    report_ids.push($(this).val());
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.export-report') }}",
                    method: "get",
                    data: {
                        reports: report_ids,
                    },
                    xhrFields:{
                        responseType: 'blob'
                    },
                    success: function(data) 
                        {
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(data);
                            link.download = `Reports.csv`;
                            link.click();
                        },
                        fail: function(data) {
                            alert('Not downloaded');
                            console.log('fail',  data);
                        }
                })
        })


        //filter data
        const table=$('#reportdatatable-table')
        table.on('preXhr.dt',function(e,settings,data){
            data.start_date = $('#time1').val();
            data.end_date=$('#time2').val();
            console.log(data.start_date,data.end_date)
        });
        $('.filter').on('click',function(){
            table.DataTable().ajax.reload();
            return false;
        })

        //reset data
        $(".reset").on('click',function(){
            table.on('preXhr.dt',function(e,settings,data){
            $("#time1").val('');
            $("#time2").val('');
            data.start_date ='';
            data.end_date='';
            console.log(data.start_date,data.end_date)
        });
            table.DataTable().ajax.reload();
                return false;
        })
     
    </script>
    @endpush