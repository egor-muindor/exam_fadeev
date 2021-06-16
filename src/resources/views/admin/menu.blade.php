@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                @include('layouts.message_block')
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col text-left">
                                <h2>Панель управления</h2>
                            </div>
                            <div class="col text-right">
                                <strong><a class="text-info">Администратор</a></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Управление аккаунтами</h4>

                        <div class="form-group">
                            <a class="btn btn-outline-primary mb-1" href="{{ route('admin.createUser') }}">Добавить нового
                                пользователя</a>
                            <a class="btn btn-outline-primary mb-1" href="{{ route('admin.allUsers') }}">Список
                                пользователей</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
