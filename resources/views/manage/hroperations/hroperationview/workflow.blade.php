@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div style="padding-top:5px;padding-bottom: 5px;"
            class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <!--<h4 class="mb-sm-0">Basic</h4>-->

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="las la-home"></i></a></li>
                    <li class="breadcrumb-item active">HR Operations</li>
                    <li class="breadcrumb-item active">Workflow</li>

                </ol>
            </div>
        </div>
    </div>
</div>
@include('manage.hroperations.hropeerations_widget_workflow')

<div class="card mt-2 mb-2">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified float-start" role="tablist">
                @foreach($masterTransactionNames as $item)
                @php
                $route = $item->route_define;
                $isValidRoute = $route && $route !== '#' && $route !== '[]' && Route::has($route);
                @endphp
                
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}"
                        href="{{ route($route) }}"
                        role="tab"
                        aria-selected="{{ request()->routeIs($route) ? 'true' : 'false' }}">
                        <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                        <span class="d-none d-sm-block">{{ $item->name }}</span>
                    </a>
                </li>
              
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection