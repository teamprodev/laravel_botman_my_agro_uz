
@extends('voyager::master')
@section('content')
<table class="table">
    @php
        $lang = app()->getLocale();
        dd($lang);
    @endphp
    <thead>
      <tr>
        <th scope="col">{{ ($lang == "uz" ? IDDdd : ID) }}</th>
        <th scope="col">Title</th>
        <th scope="col">Region</th>
        <th scope="col">Route</th>
        <th scope="col">Author</th>
        <th scope="col">Action</th>
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
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
                <td style=" color: white; {{ $appeal->status==1 ? 'background: green;' : ($appeal->status==2 ? 'background: yellow;' : 'background: red;') }}">{{ $appeal->status==1 ? "Open" : 'Closed' }}</td>
                <td scope="row"><a class="btn btn-primary" href="{{ route('voyager.appeals.show', $appeal->id) }}">Show</a>
                    <a class="btn btn-warning" href="{{ route('voyager.appeals.edit', $appeal->id) }}">Edit</a>
                    <a class="btn btn-danger" href="{{ route('voyager.appeals.destroy', $appeal->id) }}">Delete</a>
                    <a class="btn btn-primary" href="{{ route('answer.redirect', $appeal->id) }}">To EXpert</a>
                    <a class="btn btn-primary" href="{{ route('conversation.index', $appeal->id) }}">Chat</a>

                </td>
             </tr>
        @endforeach
    </tbody>
  </table>
  {{ $appeals->links('pagination::bootstrap-4') }}
@endsection
