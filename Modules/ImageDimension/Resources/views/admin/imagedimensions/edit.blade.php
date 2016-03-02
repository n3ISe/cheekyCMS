@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('imagedimension::imagedimensions.title.edit imagedimension') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.imagedimension.imagedimension.index') }}">{{ trans('imagedimension::imagedimensions.title.imagedimensions') }}</a></li>
        <li class="active">{{ trans('imagedimension::imagedimensions.title.edit imagedimension') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content') 
    {!! Form::model($imagedimension,['route' => ['admin.imagedimension.imagedimension.update', $imagedimension->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <div class="row">
						<div class="col-sm-4">
							<div class="form-group{{ $errors->has('dimension') ? ' has-error' : '' }}">
								{!! Form::label('dimension', trans('Dimension')) !!}
								{!! Form::text('dimension', Input::old('dimension'), ['class' => 'form-control', 'placeholder' => trans('Dimension'),'required']) !!}
								{!! $errors->first('dimension', '<span class="help-block">:message</span>') !!}
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
								{!! Form::label('status', trans('Status')) !!}
								{!! Form::select('status', array('1' => 'Active', '0' => 'Disable'), null,['class' => 'form-control','required']) !!}
								{!! $errors->first('status', '<span class="help-block">:message</span>') !!}
							</div>
						</div>
					</div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.imagedimension.imagedimension.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
                    { key: 'b', route: "<?= route('admin.imagedimension.imagedimension.index') ?>" }
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
