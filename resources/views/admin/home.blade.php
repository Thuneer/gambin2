@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <span class="page-header__icon"><i class="fas fa-tachometer-alt"></i></span><h1 class="page-header">Dashboard</h1>
        </div>
    </div>

    <div class="container-fluid dashboard dashboard__container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 dashboard-items__container">
                <div class="dashboard__item">
                    <h3 class="dashboard__header">
                        Latest Users
                    </h3>
                    <a class="dashboard__all" href="/admin/users">All users</a>
                    <div class="dashboard__content">
                        <div class="dashboard-items">
                            @foreach ($users as $user)
                                <a href="/admin/users/{{ $user->id }}/edit" class="dashboard-items__item">
                                    <img class="dashboard-items__img dashboard-items__img--rounded" src="@if(count($user->images) > 0)/{{ $user->images[0]->path . '.-1-1-sm' . $user->images[0]->extension }} @else{{ userAvatar($user->id) }} @endif" alt="">
                                    <span class="dashboard-items__name"> {{ $user->first_name }} {{ $user->last_name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 dashboard-items__container">
                <div class="dashboard__item">
                    <h3 class="dashboard__header">
                        Latest Articles
                    </h3>
                    <a class="dashboard__all" href="/admin/articles">All articles</a>
                    <div class="dashboard__content">
                        <div class="dashboard-items">
                            @foreach ($articles as $article)
                                <a href="/admin/articles/{{ $article->id }}/edit" class="dashboard-items__item">
                                    <img class="dashboard-items__img" src="/{{ $article->images[0]->path . '-1-1-sm.' . $article->images[0]->extension }}" alt="">
                                    <span class="dashboard-items__name"> {{ $article->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 dashboard-items__container">
                <div class="dashboard__item">
                    <h3 class="dashboard__header">
                        Latest Pages
                    </h3>
                    <a class="dashboard__all" href="/admin/pages">All pages</a>
                    <div class="dashboard__content">
                        <div class="dashboard-items">
                            @foreach ($pages as $page)
                                <a href="/admin/pages/{{ $page->id }}/edit" class="dashboard-items__item">
                                    <span class="dashboard-items__name"> {{ $page->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-8 col-md-6 col-lg-8 dashboard-items__container">
                <div class="dashboard__item">
                    <h3 class="dashboard__header">
                        Articles last 7 days
                    </h3>
                    <div class="dashboard-items__chart">
                        <canvas id="myChart1" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 col-md-6 col-lg-4 dashboard-items__container">
                <div class="dashboard__item">
                    <h3 class="dashboard__header">
                        Total values
                    </h3>
                    <div class="dashboard-items__chart">
                        <canvas id="myChart2" width="400" height="320"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @component('admin/components/message')@endcomponent

@endsection
