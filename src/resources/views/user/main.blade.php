@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                @include('layouts.message_block')
                <div class="card">
                    <div class="card-body">
                        <p>
                            Hi {{ Auth::user()->first_name }} {{ Auth::user()->last_name }},
                            Welcome to AMONIC Airlines Automation System
                        </p>
                        <p>
                            Time spent on system: {{\App\Models\UserLogs::getSummaryActivityLastMonth(Auth::user()->id)}}
                        </p>
                        <p>
                            Number of crashes: {{\App\Models\UserLogs::numberOfCrashes(Auth::user()->id)}}
                        </p>
                        <table class="table table-hover table-responsive-sm">
                            <thead>
                            <th>Date</th>
                            <th>Login time</th>
                            <th>Logout time</th>
                            <th>Time spent on system</th>
                            <th>Unsuccessful logout reason</th>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log['Date'] }}</td>
                                    <td>{{ $log['Login Time'] }}</td>
                                    <td>{{ $log['Logout Time'] }}</td>
                                    <td>{{ $log['Time spend on system'] === '' ? '' : $log['Time spend on system']->format('%H:%I:%S') }}</td>
                                    <td>{{ $log['Reason'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
