@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary margin-bottom" href="{{ url('notifications/'.$page) }}">@if ($type === 'archive') {{ trans('notifications.btn.notifications') }} @else {{ trans('notifications.btn.archive') }} @endif</a>
        <div class="pull-right"><a class="btn btn-success margin-bottom" href="#" id="show-notification">{{ trans('notifications.btn.new') }}</a></div>
    </div>
</div>
<div class="row" id="notification-form">
    <div class="col-md-12">
        <form class="form-horizontal" id="new-notification-form">
            <input type="hidden" name="_method" value="put" />
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">{{ trans('notifications.label.title') }}</label>
                <div class="col-sm-10">
                    <input class="form-control" id="title" name="title" placeholder="{{ trans('notifications.label.title') }}">
                    <div class="text-red form-error"><small></small></div>
                </div>
            </div>
            <div class="form-group">
                <label for="notification" class="col-sm-2 control-label">{{ trans('notifications.label.message') }}</label>
                <div class="col-sm-10">
                    <textarea class="form-control" row="3" id="body" name="body" placeholder="{{ trans('notifications.label.message') }}"></textarea>
                    <div class="text-red form-error"><small></small></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="create-notification">{{ trans('notifications.btn.create') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="timeline">
            @foreach ($notifications as $notification)
            <li id="{{ $notification->notifications_id }}">
                <i class="fa fa-envelope bg-@if ($notification->key == 'sticky')yellow @else{{ $bg }} @endif"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> {{ $notification->datetime }}</span>
                    <h3 class="timeline-header">{{ $notification->title }}</h3>
                    <div class="timeline-body">
                        {{ $notification->body }}
                    </div>
                    <div class="timeline-footer">
                        @if ($type === 'archive')
                        <a class="btn btn-danger btn-xs notification" id="read" data-id="{{ $notification->notifications_id }}" data-action="unread"><i class="fa fa-eye"></i> {{ trans('notifications.btn.markunread') }}</a>
                        @else
                            @if ($notification->key === 'sticky')
                            <a class="btn btn-primary btn-xs notification" id="unsticky" data-id="{{ $notification->notifications_id }}" data-action="unsticky"><i class="fa fa-bell-o"></i> {{ trans('notifications.btn.unsticky') }}</a>
                            @else
                            <a class="btn btn-primary btn-xs notification" id="sticky" data-id="{{ $notification->notifications_id }}" data-action="sticky"><i class="fa fa-bell-o"></i> {{ trans('notifications.btn.sticky') }}</a>
                            @endif
                        <a class="btn btn-danger btn-xs notification" id="read" data-id="{{ $notification->notifications_id }}" data-action="read"><i class="fa fa-eye"></i> {{ trans('notifications.btn.markread') }}</a>
                        @endif
                        <div class="pull-right">
                            <p class="text-muted">Source -
                                @if ($notification->username !== null)
                                    @if ($notification->username !== Auth::user()->username)
                                    {{ $notification->username }}
                                    @else
                                    {{ trans('notifications.text.you') }}
                                    @endif
                                @else
                                {{ $notification->source }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary margin-bottom" href="{{ url('notifications/'.$page) }}">@if ($type === 'archive') {{ trans('notifications.btn.notifications') }} @else {{ trans('notifications.btn.archive') }} @endif</a>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ url('js/pages/notifications.js') }}"></script>
    <script>
        $.Notifications.markNotification('{{ url('/') }}');
        $.Notifications.newNotification('#new-notification-form');
    </script>
@endsection
