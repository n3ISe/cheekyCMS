@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('location::locations.title.create location') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.location.location.index') }}">{{ trans('location::locations.title.locations') }}</a></li>
        <li class="active">{{ trans('location::locations.title.create location') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.location.location.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <div class="box-body">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
									{!! Form::label('name', trans('Location Name')) !!}
									{!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => trans('Location Name'),'required']) !!}
									{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
									{!! Form::label('city', trans('City')) !!}
									{!! Form::text('city', Input::old('city'), ['class' => 'form-control', 'placeholder' => trans('City'),'required']) !!}
									{!! $errors->first('city', '<span class="help-block">:message</span>') !!}
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
									{!! Form::label('region', trans('Region')) !!}
									{!! Form::text('region', Input::old('region'), ['class' => 'form-control', 'placeholder' => trans('Region'),'required']) !!}
									{!! $errors->first('region', '<span class="help-block">:message</span>') !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
									{!! Form::label('country', trans('Country')) !!}
									{!! Form::text('country', Input::old('country'), ['class' => 'form-control', 'placeholder' => trans('Country'),'required']) !!}
									{!! $errors->first('country', '<span class="help-block">:message</span>') !!}
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('coord_lat') ? ' has-error' : '' }}">
									{!! Form::label('coord_lat', trans('Latitude')) !!}
									{!! Form::number('coord_lat', Input::old('coord_lat'), ['class' => 'form-control', 'placeholder' => trans('Latitude'),'required','step'=>'any']) !!}
									{!! $errors->first('coord_lat', '<span class="help-block">:message</span>') !!}
								</div>
							</div>
							<div class="col-sm-4">		
								<div class="form-group{{ $errors->has('coord_lang') ? ' has-error' : '' }}">
									{!! Form::label('coord_long', trans('Longtitude')) !!}
									{!! Form::number('coord_long', Input::old('coord_long'), ['class' => 'form-control', 'placeholder' => trans('Longtitude'),'required','step'=>'any']) !!}
									{!! $errors->first('coord_long', '<span class="help-block">:message</span>') !!}
								</div>
							</div>
						</div>
					</div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.location.location.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
                    { key: 'b', route: "<?= route('admin.location.location.index') ?>" }
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
