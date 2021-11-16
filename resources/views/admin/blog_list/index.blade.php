@extends('layouts.master')
@section('page_title', 'Blog List')

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
                                    <button class="btn btn-success btn-save float-right" title="Add " data-toggle="modal"
                                        data-target="#blog_category" data-id="'.$data->id.'">Add </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- ajax form response -->

                                <div class="ajax-msg"></div>
                                <div class="table-responsive">
                                    {!! $dataTable->table(['class' => 'table table-bordered dt-responsive']) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    </section>
    


@endsection
@push('page_scripts')
{!! $dataTable->scripts() !!}
@endpush