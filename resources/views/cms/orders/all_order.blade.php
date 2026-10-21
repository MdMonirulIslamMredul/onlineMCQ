@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Orders</h1>
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
                                        <th>Date</th>
                                        <th>Student Name</th>
                                        <th>Student Phone</th>
                                        <th>Student Email</th>
                                        <th>Exam Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($Orders as $order)
                                        @php( $examQ = DB::table('exams')->where('id', $order->examID)->first() )
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ date("d M, Y", strtotime($order->date)) }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ optional($examQ)->exam_name }}</td>
                                            <td>{{ number_format($order->amount, 2) }}</td>
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
