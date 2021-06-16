@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            @include('layouts.message_block')
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-1">
                                <a
                                    role="button" tabindex="0" class="btn btn-secondary"
                                    href="{{ route('admin.menu') }}"
                                >Назад</a>
                            </div>
                            <div class="col">
                                <h2 class="text-center">Добавить пользователя</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.storeUser') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input id="email" required class="form-control" name="email" type="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="first_name" class="col-form-label">First name:</label>
                                <input id="first_name" required class="form-control" name="first_name" type="text" placeholder="First name">
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-form-label">Last name:</label>
                                <input id="last_name" required class="form-control" name="last_name" type="text" placeholder="Last name">
                            </div>
                            <div class="form-group">
                                <label for="office">Office</label>
                                <select name="office" id="office" class="custom-select" required>
                                    @foreach($offices as $office)
                                    <option value="{{$office->id}}">{{$office->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="birth_date" class="col-form-label">Birthdate:</label>
                                <input id="birth_date" required class="form-control" name="birth_date" type="date" placeholder="Birthdate">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input id="password" required class="form-control" name="password" type="password" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
