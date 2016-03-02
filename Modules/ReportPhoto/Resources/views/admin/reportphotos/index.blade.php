@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('reportphoto::reportphotos.title.reportphotos') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('reportphoto::reportphotos.title.reportphotos') }}</li>
    </ol>
@stop

@section('content')
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
                            <th>Category</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Reason</th>
                            <th>Reported On</th>
                            <th>Status</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($reportphotos)): ?>
                        <?php foreach ($reportphotos as $reportphoto): ?>
                        <tr>
                            <td>
								{!! $reportphoto->module->name !!}<br/>
								<a>
									{{ $reportphoto->restaurant->name }}									
								</a>
                            </td>
							<td>
								<?php
								$image_folder = $reportphoto->module->id == 1 ? 'restaurant_photo' : 'review_photo';
								$image		  = $reportphoto->module->id == 1 ? Modules\RestaurantImage\Entities\RestaurantImage::getRestaurantImage($reportphoto->photo_id) : Modules\ReviewImage\Entities\ReviewImage::getReviewImage($reportphoto->photo_id);
								?>
								<image src="{!! config('filesystems.disks.s3.url') . $image_folder.'/cap100/'.$image!!}"/>
							</td>
                            <td>
                                {{ $reportphoto->name }}<br/>
                                {{ $reportphoto->email }}
                            </td>
                            <td>
                                {{ $reportphoto->reason->reason }}<br/>
                                <i>{{ str_limit($reportphoto->comment,100) }}</i>
                            </td>
                            <td>
                                {{ date("d-m-Y", strtotime($reportphoto->created_at)) }}
                            </td>
                            <td>
                                {{ $reportphoto->active == 1 ? "Pending for action" : "Image disabled" }}
                            </td>
                            <td>
                                <div class="btn-group">
									<?php
									if ($reportphoto->active == 1)
									{
										?>
										<button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.reportphoto.reportphoto.destroy', [$reportphoto->id]) }}"><i class="fa fa-trash"></i></button>
										<?php
									}									
									?>
                                    
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Reason</th>
                            <th>Reported On</th>
                            <th>Status</th>
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
        <dd>{{ trans('reportphoto::reportphotos.title.create reportphoto') }}</dd>
    </dl>
@stop

@section('scripts')
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 4, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop
