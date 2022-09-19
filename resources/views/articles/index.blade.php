@extends('app')

@section('title', '記事一覧')

@section('content')
  @include('nav')
  <div class="container">
    <ul>
      @foreach ($articles as $article)
        <li>{{ $article->title }}</li>  
        <li>{{ $article->body }}</li>  
      @endforeach
    </ul>
@endsection
