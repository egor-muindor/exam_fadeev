@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                @include('layouts.message_block')
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-1">
                                <a
                                    role="button" tabindex="0" class="btn btn-secondary"
                                    href="{{ route('admin.menu') }}"
                                >Назад</a>
                            </div>
                            <div class="col-3">
                                <form action="{{route('admin.allUsers')}}" method="get">
                                    <div class="form-group">
                                        <select onchange="this.form.submit()" name="office" id="office" class="custom-select" required>
                                            <option @if ($office === 'all') selected @endif value="all">All</option>
                                            @foreach($offices as $item)
                                                <option @if ($office == $item->id) selected @endif value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-8">
                                <div class="col">
                                    <h3 class="text-left">Список зарегистрированных пользователей</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($users->count() === 0)
                            <h3 class="text-center">
                                Список пользователей пуст
                            </h3>
                        @else
                            <table class="table table-hover table-responsive-sm">
                                <thead>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Age</th>
                                <th>User Role</th>
                                <th>Email Address</th>
                                <th>Office</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr @if($user->isBlocked()) style="background-color: red;" @endif  @if($user->isOnline()) style="background-color: green;" @endif>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->birth_date->age }}</td>
                                        <td>{{ $user->role->title }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->office->title }}</td>
                                        <td>
                                            <form action="{{route('admin.changeRole')}}" method="post">
                                                @csrf
                                                <input hidden value="{{$user->id}}" name="user_id">
                                                <button class="btn-sm btn-primary" type="submit">изменить роль</button>
                                            </form>
                                            <form action="{{route('admin.blockUser')}}" method="post">
                                                @csrf
                                                <input hidden value="{{$user->id}}" name="user_id">
                                                <button class="btn-sm btn-danger" type="submit">Enable/Disable user</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
