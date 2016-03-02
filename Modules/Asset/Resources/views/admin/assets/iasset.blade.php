@extends('layouts.master')

@section('content-header')
    <h1>
        {{ $restaurant->name .' '. trans('asset::assets.title.assets') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('asset::assets.title.assets') }}</li>
    </ol>
@stop

@section('styles')
<link href="{!! Module::asset('media:css/dropzone.css') !!}" rel="stylesheet" type="text/css" />
<style>
.dropzone {
    border: 1px dashed #CCC;
    min-height: 227px;
    margin-bottom: 20px;
}
</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<form method="POST" class="dropzone">
				{!! Form::token() !!}
			</form>
		</div>
	</div>
    <div class="row">
        <div class="col-xs-12">	
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Width (px)</th>
                            <th>Height (px)</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($assets)): ?>
                        <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td>
                                <image src="{!! config('filesystems.disks.s3.url') . 'restaurant_assets_v2/cap100/'.$asset->image_name!!}"/>
                             </td>
                            <td>
                                {!! $asset->width !!}
                            </td>
                            <td>
                                {!! $asset->height !!}
                            </td>
                            <td>
                                <div class="btn-group">
									<button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.asset.asset.destroy', [$asset->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>Width (px)</th>
                            <th>Height (px)</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('asset::assets.title.create asset') }}</dd>
    </dl>
@stop

@section('scripts')
	<script src="{!! Module::asset('asset:js/dropzone.js') !!}"></script>
	<?php $config = config('asgard.asset.config'); ?>
	<script>
		var maxFilesize = '<?php echo $config['max-file-size'] ?>',
				acceptedFiles = '<?php echo $config['allowed-types'] ?>';
	</script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
			var baseUrl = "{{ url('/en/backend') }}";
			var token = "{{ Session::getToken() }}";
			Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone(".dropzone", {
				url: baseUrl + "/asset/assets/{!! $restaurant->id !!}/sasset",
				maxFilesize: maxFilesize,
				acceptedFiles: acceptedFiles,
				params: {
					_token: token
				}
			});
			myDropzone.on("queuecomplete", function(file, http) {
				window.setTimeout(function(){
					location.reload();
				}, 1500);
			});
			myDropzone.on("sending", function(file, fromData) {
				if ($('.alert-danger').length > 0) {
					$('.alert-danger').remove();
				}
			});
			myDropzone.on("error", function(file, errorMessage) {
				var html = '<div class="alert alert-danger" role="alert">' + errorMessage + '</div>';
				$('.col-md-12').first().prepend(html);
				setTimeout(function() {
					myDropzone.removeFile(file);
				}, 2000);
			});
			
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": false,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop
