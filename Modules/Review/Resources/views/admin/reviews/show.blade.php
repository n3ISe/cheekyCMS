@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Review Details') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.review.review.ireview',[$review->restaurant_id]) }}">{{ trans('review::reviews.title.reviews') }}</a></li>
        <li class="active">{{ trans('Review Details') }}</li>
    </ol>
@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">       
                <div class="tab-content">
					<div class="tab-pane active" id="tab_1-1">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-4">
									<i>
										Posted by {!! $review->user->name !!}, on {!! date("d-m-Y", strtotime($review->created_at)) !!}
									</i>									
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm-12">
									<b>{!! $review->title !!}</b><br/>
									<i>
										{!! $review->comment !!}
									</i>									
								</div>
							</div>
							<br/>
							<?php
							if (isset($reviewImages))
							{
								?>
								<div class="row">
									<?php
									foreach ($reviewImages as $reviewImage)
									{
										?>
										<div class="col-sm-4">
											<image src="{!! config('filesystems.disks.s3.url') . 'review_photo/cap300/'.$reviewImage->photo !!}"/>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>
							<div class="row">
								<div class="col-sm-12">
									Rating : <b>{!! $review->rating !!}</b><br/>									
								</div>
							</div>
						</div>
					</div>
					
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
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
                    { key: 'b', route: "<?= route('admin.review.review.index') ?>" }
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
