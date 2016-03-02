@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('reportreason::reportreasons.title.edit reportreason') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.reportreason.reportreason.index') }}">{{ trans('reportreason::reportreasons.title.reportreasons') }}</a></li>
        <li class="active">{{ trans('reportreason::reportreasons.title.edit reportreason') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::model($reportreason,['route' => ['admin.reportreason.reportreason.update', $reportreason->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">                                   
                    <div class="row">
						<div class="col-sm-4">
							<div class="form-group{{ $errors->has('dimension') ? ' has-error' : '' }}">
								{!! Form::label('reason', trans('Reason')) !!}
								{!! Form::text('reason', Input::old('reason'), ['class' => 'form-control', 'placeholder' => trans('Reason'),'required']) !!}
								{!! $errors->first('reason', '<span class="help-block">:message</span>') !!}
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
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.reportreason.reportreason.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
                    { key: 'b', route: "<?= route('admin.reportreason.reportreason.index') ?>" }
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
