@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('restaurantimage::restaurantimages.title.restaurantimages') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('restaurantimage::restaurantimages.title.restaurantimages') }}</li>
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
                            <th>Restaurant</th>
                            <th>Total Images</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($restaurants)): ?>
                        <?php foreach ($restaurants as $restaurant): ?>
                        <tr>
                            <td>
                                <a href="{{ route('admin.restaurantimage.restaurantimage.image', [$restaurant->id]) }}">
                                    {{ $restaurant->name }}
                                </a>
                            </td>
                            <td>
								{!! $restaurant->total_image !!}
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Restaurant</th>
                            <th>Total Images</th>
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
        <dd>{{ trans('restaurantimage::restaurantimages.title.create restaurantimage') }}</dd>
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
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop
