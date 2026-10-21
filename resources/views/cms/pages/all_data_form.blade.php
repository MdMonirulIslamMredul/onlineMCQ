@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Contact  Form Submitted Data</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($Orders as $order)

                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->number }}</td>
                                            <td>{{ date("d F, Y", strtotime($order->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
