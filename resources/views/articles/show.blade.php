@extends('layouts.app')

@section('content')
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <label>Title</label>
        <input type="text" name="title" style="width:100%;" value="{{ $article->title }}">
        <label>Content</label>
        <textarea name="content" rows="10" style="width:100%;">{{ $article->content }}</textarea>
        
@endsection