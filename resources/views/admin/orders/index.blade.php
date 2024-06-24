@extends('layouts.app')

@section('content')
    <!-- breadcrumb -->
    <nav area-label="breadcrumb">

        <ol class="breadcrumb">
            <a href="{{ route('home') }}" class="text-decoration-none mr-3">
                <li class="breadcrumb-item">Home</li>
            </a>
            <li class="breadcrumb-item active">Orders</li>
        </ol>

    </nav>

    <div class="card ">
        <div class="card-header">Orders</div>

        <div class="card-body">
            <style>
                .table th,
                .table td {
                    padding: 15px;
                    text-align: left;
                }

                .table th {
                    background-color: #343a40;
                    color: white;
                }

                .table-responsive {
                    overflow-x: auto;
                }

                .card-body {
                    padding: 2rem;
                }
            </style>

            <table class="table w-full table-bordered table-hover  table-responsive ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Amount</th>
                        <th>Pay Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Check</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->billing_fullname }}</td>
                            <td>{{ $order->billing_phone }}</td>
                            <td>{{ $order->billing_address }}</td>
                            <td>{{ $order->billing_city }}</td>
                            <td>rwf {{ $order->billing_total }}</td>
                            <td>{{ $order->payment_method === 'paynow' ? 'online' : 'on delivery' }}</td>
                            </td>
                            <td class="text-capitalize">{{ $order->status }}</td>
                            <td>{{ $order->updated_at }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-success btn-sm">View
                                    Order</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $orders->links() }}
@endsection
