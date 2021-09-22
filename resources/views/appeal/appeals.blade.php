
@extends('voyager::master')
@section('content')
<table class="table">
    @php
        $lang = app()->getLocale();
    @endphp
    <thead>
      <tr>
        <th scope="col">ID</th>
<<<<<<< HEAD
        <th scope="col">Title</th>
        <th scope="col">Region</th>
        <th scope="col">Route</th>
        <th scope="col">Author</th>
        <th scope="col">Action</th>
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
=======
        <th scope="col">{{ $lang == "en" ? "Title" : ($lang == "uz" ? "Mavzu" : "Тема") }}</th>
        <th scope="col">{{ $lang == "en" ? "Region" : ($lang == "uz" ? "Viloyat" : "Область") }}</th>
        <th scope="col">{{ $lang == "en" ? "Route" : ($lang == "uz" ? "Yo'nalish" : "Направление") }}</th>
        <th scope="col">{{ $lang == "en" ? "Author" : ($lang == "uz" ? "Muallif" : "Автор") }}</th>
        <th scope="col">{{ $lang == "en" ? "Action" : ($lang == "uz" ? "Murojaat turi" : "Тип заявления") }}</th>
        <th scope="col">{{ $lang == "en" ? "Status" : ($lang == "uz" ? "Holati" : "Cтатус") }}</th>
        <th scope="col">{{ $lang == "en" ? "Actions" : ($lang == "uz" ? "Harakatlar" : "Действия") }}</th>
>>>>>>> f062c56cf533bdf3bc2431b7e8e4376a0d847df7
      </tr>
    </thead>
    <tbody>
        @forelse($appeals as $appeal)
            <tr>
                {{-- @dd($appeal->user()->first()->name); --}}
                <th scope="row">{{ $appeal->id }}</th>
                <td>{{ $appeal->title }}</td>
                <td>{{ ($appeal->region()->first() !== null) ? ($lang == "ru" ? $appeal->region()->first()->ru : $appeal->region()->first()->uz) : 'Deleted Region' }}</td>
                <td>{{  ($appeal->routes()->first() !== null) ? ($lang == "ru" ? $appeal->routes()->first()->ru : $appeal->routes()->first()->uz) : 'Deleted Route' }}</td>
                <td>{{  ($appeal->user()->first() !== null) ? $appeal->user()->first()->name : 'Deleted User' }}</td>
                <td>{{ ($appeal->action()->first() !== null) ? ($lang == "ru" ? $appeal->action()->first()->ru : $appeal->action()->first()->uz) : 'Deleted User' }}</td>
                <td style=" color: white; {{ $appeal->status==1 ? 'background: rgb(0, 211, 0);' : ($appeal->status==2 ? 'background: rgb(226, 226, 0);' : 'background: #BBBBBB;') }}">{{ $appeal->status==1 ? "Open" : ($appeal->status==2 ? 'Moderating' : 'Closed') }}</td>
                <td scope="row"><a class="btn btn-primary" href="{{ route('voyager.appeals.show', $appeal->id) }}">Show</a>
                    <a class="btn btn-warning" href="{{ route('voyager.appeals.edit', $appeal->id) }}">Edit</a>
                    <a class="btn btn-danger" href="{{ route('voyager.appeals.destroy', $appeal->id) }}">Delete</a>
                    <a class="btn btn-primary" href="{{ route('answer.redirect', $appeal->id) }}">To Expert</a>
                    <a class="btn btn-primary" href="{{ route('conversation.index', $appeal->id) }}">Chat</a>

                </td>
             </tr>
        @endforeach
    </tbody>
  </table>
  {{ $appeals->links('pagination::bootstrap-4') }}
@endsection
