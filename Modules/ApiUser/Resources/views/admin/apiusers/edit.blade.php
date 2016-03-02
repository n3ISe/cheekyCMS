@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('apiuser::apiusers.title.edit apiuser') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.apiuser.apiuser.index') }}">{{ trans('apiuser::apiusers.title.apiusers') }}</a></li>
        <li class="active">{{ trans('apiuser::apiusers.title.edit apiuser') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.apiuser.apiuser.update', $apiuser->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <div class="row">
						<div class="col-sm-4">
							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								{!! Form::label('name', trans('Name')) !!}
								{!! Form::text('name', Input::old('name', $apiuser->name), ['class' => 'form-control', 'placeholder' => trans('Name'),'required']) !!}
								{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								{!! Form::label('email', trans('Email')) !!}
								{!! Form::email('email', Input::old('email', $apiuser->email), ['class' => 'form-control', 'placeholder' => trans('Email'),'required']) !!}
								{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								{!! Form::label('password', trans('Password')) !!}
								{!! Form::input('password', 'password', '', ['class' => 'form-control', 'placeholder' => trans('Password'),'required']) !!}
								{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
							</div>
						</div>
					</div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.apiuser.apiuser.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.apiuser.apiuser.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@stop
