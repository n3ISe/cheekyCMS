@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('restaurant::restaurants.title.edit restaurant') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.restaurant.restaurant.index') }}">{{ trans('restaurant::restaurants.title.restaurants') }}</a></li>
        <li class="active">{{ trans('restaurant::restaurants.title.edit restaurant') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::model($restaurant,['route' => ['admin.restaurant.restaurant.update', $restaurant->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">                
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1-1" data-toggle="tab">Data</a></li>
					<li class=""><a href="#tab_2-2" data-toggle="tab">Tags</a></li>
					<li class=""><a href="#tab_3-3" data-toggle="tab">Operating Hours</a></li>
				</ul>
                <div class="tab-content">
					<div class="tab-pane active" id="tab_1-1">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
										{!! Form::label('name', trans('Restaurant Name')) !!}
										{!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => trans('Restaurant Name'),'required']) !!}
										{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group{{ $errors->has('location_id') ? ' has-error' : '' }}">
										{!! Form::label('location_id', trans('Location')) !!}
										{!! Form::select('location_id', $locations, $selected,['class' => 'form-control','required']) !!}
										{!! $errors->first('location_id', '<span class="help-block">:message</span>') !!}
									</div>
							   </div>
								 <div class="col-sm-4">
									<div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
										{!! Form::label('phone_number', trans('Phone No.')) !!}
										{!! Form::text('phone_number', Input::old('phone_number'), ['class' => 'form-control', 'placeholder' => trans('Phone Number')]) !!}
										{!! $errors->first('phone_number', '<span class="help-block">:message</span>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
										{!! Form::label('category_id', trans('Category')) !!}
										{!! Form::select('category_id', $categories, null,['class' => 'form-control','required']) !!}
										{!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
									</div>
									
									<div class="form-group{{ $errors->has('cuisine_type_id') ? ' has-error' : '' }}">
										{!! Form::label('cuisine_type_id', trans('Cuisine Type')) !!}
										{!! Form::select('cuisine_type_id', $cuisines, null,['class' => 'form-control','required']) !!}
										{!! $errors->first('cuisine_type_id', '<span class="help-block">:message</span>') !!}
									</div>
									
									<div class="form-group{{ $errors->has('coord_lat') ? ' has-error' : '' }}">
										{!! Form::label('coord_lat', trans('Latitude')) !!}
										{!! Form::number('coord_lat', Input::old('coord_lat'), ['class' => 'form-control', 'placeholder' => trans('Latitude'),'required','step'=>'any']) !!}
										{!! $errors->first('coord_lat', '<span class="help-block">:message</span>') !!}
									</div>
									
									<div class="form-group{{ $errors->has('coord_lang') ? ' has-error' : '' }}">
										{!! Form::label('coord_long', trans('Longtitude')) !!}
										{!! Form::number('coord_long', Input::old('coord_long'), ['class' => 'form-control', 'placeholder' => trans('Longtitude'),'required','step'=>'any']) !!}
										{!! $errors->first('coord_long', '<span class="help-block">:message</span>') !!}
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
										{!! Form::label('address', trans('Address')) !!}
										{!! Form::textarea('address', Input::old('address'), ['class' => 'form-control', 'placeholder' => trans('Address'),'required','style'=>'resize:none;']) !!}
										{!! $errors->first('address', '<span class="help-block">:message</span>') !!}
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
										{!! Form::label('description', trans('Description')) !!}
										{!! Form::textarea('description', Input::old('description'), ['class' => 'form-control', 'placeholder' => trans('Description'),'style'=>'resize:none;']) !!}
										{!! $errors->first('description', '<span class="help-block">:message</span>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
										{!! Form::label('active', trans('Status')) !!}
										{!! Form::select('active', array('1' => 'Active', '0' => 'Disable'), null,['class' => 'form-control','required']) !!}
										{!! $errors->first('active', '<span class="help-block">:message</span>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="tab_2-2">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Tags</label>
									<select multiple="" class="form-control" name="tags[]">
										<?php foreach ($tags as $tag): ?>
											<option value="{{ $tag->id }}" <?php echo $restaurant->hasTagId($tag->id,$restaurant->id) ? 'selected' : '' ?>>{{ $tag->name }}</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab_3-3">
						<div class="box-body">
							<?php
							$day_name = array(1=>"Monday",2=>"Tuesday",3=>"Wednesday",4=>"Thursday",5=>"Friday",6=>"Saturday",7=>"Sunday");
							foreach ($operatings as $operating)
							{
								?>
								<div class="row">
									<div class="col-sm-13">
										<label>{!! $day_name[$operating->day] !!}</label><br/>
										{!! Form::hidden('day[]',$operating->day) !!}
										<div class="col-sm-4">
											<div class="form-group">
												<label>Timezone</label>
												{!! Form::select('timezone[]', 
														array(
															'-1200' => '(GMT-12:00)', '-1100' => '(GMT-11:00)',
															'-1000' => '(GMT-10:00)', '-0900' => '(GMT-09:00)',
															'-0800' => '(GMT-08:00)', '-0700' => '(GMT-07:00)',
															'-0600' => '(GMT-06:00)', '-0500' => '(GMT-05:00)',
															'-0400' => '(GMT-04:00)', '-0300' => '(GMT-03:00)',
															'-0200' => '(GMT-02:00)', '-0100' => '(GMT-01:00)',
															'+0000' => '(GMT+00:00)', '+0100' => '(GMT+01:00)',
															'+0200' => '(GMT+02:00)', '+0300' => '(GMT+03:00)',
															'+0400' => '(GMT+04:00)', '+0500' => '(GMT+05:00)',
															'+0600' => '(GMT+06:00)', '+0700' => '(GMT+07:00)',
															'+0800' => '(GMT+08:00)', '+0900' => '(GMT+09:00)',
															'+1000' => '(GMT+10:00)', '+1100' => '(GMT+11:00)',
															'+1200' => '(GMT+12:00)'
														), $operating->timezone,['class' => 'form-control']) !!}
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Open At</label>
												{!! Form::select('open[]', 
														array(
															'' => 'Closed',
															'00:00:00' => '12.00AM', '00:30:00' => '12.30AM',
															'01:00:00' => '01.00AM', '01:30:00' => '01.30AM',
															'02:00:00' => '02.00AM', '02:30:00' => '02.30AM',
															'03:00:00' => '03.00AM', '03:30:00' => '03.30AM',
															'04:00:00' => '04.00AM', '04:30:00' => '04.30AM',
															'05:00:00' => '05.00AM', '05:30:00' => '05.30AM',
															'06:00:00' => '06.00AM', '06:30:00' => '06.30AM',
															'07:00:00' => '07.00AM', '07:30:00' => '07.30AM',
															'08:00:00' => '08.00AM', '08:30:00' => '08.30AM',
															'09:00:00' => '09.00AM', '09:30:00' => '09.30AM',
															'10:00:00' => '10.00AM', '10:30:00' => '10.30AM',
															'11:00:00' => '11.00AM', '11:30:00' => '11.30AM',
															'12:00:00' => '12.00PM', '12:30:00' => '12.30PM',
															'13:00:00' => '01.00PM', '13:30:00' => '01.30PM',
															'14:00:00' => '02.00PM', '14:30:00' => '02.30PM',
															'15:00:00' => '03.00PM', '15:30:00' => '03.30PM',
															'16:00:00' => '04.00PM', '16:30:00' => '04.30PM',
															'17:00:00' => '05.00PM', '17:30:00' => '05.30PM',
															'18:00:00' => '06.00PM', '18:30:00' => '06.30PM',
															'19:00:00' => '07.00PM', '19:30:00' => '07.30PM',
															'20:00:00' => '08.00PM', '20:30:00' => '08.30PM',
															'21:00:00' => '09.00PM', '21:30:00' => '09.30PM',
															'22:00:00' => '10.00PM', '22:30:00' => '10.30PM',
															'23:00:00' => '11.00PM', '23:30:00' => '11.30PM'
														), $operating->open,['class' => 'form-control']) !!}
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Close At</label>
												{!! Form::select('close[]', 
														array(
															'' => 'Closed',
															'00:00:00' => '12.00AM', '00:30:00' => '12.30AM',
															'01:00:00' => '01.00AM', '01:30:00' => '01.30AM',
															'02:00:00' => '02.00AM', '02:30:00' => '02.30AM',
															'03:00:00' => '03.00AM', '03:30:00' => '03.30AM',
															'04:00:00' => '04.00AM', '04:30:00' => '04.30AM',
															'05:00:00' => '05.00AM', '05:30:00' => '05.30AM',
															'06:00:00' => '06.00AM', '06:30:00' => '06.30AM',
															'07:00:00' => '07.00AM', '07:30:00' => '07.30AM',
															'08:00:00' => '08.00AM', '08:30:00' => '08.30AM',
															'09:00:00' => '09.00AM', '09:30:00' => '09.30AM',
															'10:00:00' => '10.00AM', '10:30:00' => '10.30AM',
															'11:00:00' => '11.00AM', '11:30:00' => '11.30AM',
															'12:00:00' => '12.00PM', '12:30:00' => '12.30PM',
															'13:00:00' => '01.00PM', '13:30:00' => '01.30PM',
															'14:00:00' => '02.00PM', '14:30:00' => '02.30PM',
															'15:00:00' => '03.00PM', '15:30:00' => '03.30PM',
															'16:00:00' => '04.00PM', '16:30:00' => '04.30PM',
															'17:00:00' => '05.00PM', '17:30:00' => '05.30PM',
															'18:00:00' => '06.00PM', '18:30:00' => '06.30PM',
															'19:00:00' => '07.00PM', '19:30:00' => '07.30PM',
															'20:00:00' => '08.00PM', '20:30:00' => '08.30PM',
															'21:00:00' => '09.00PM', '21:30:00' => '09.30PM',
															'22:00:00' => '10.00PM', '22:30:00' => '10.30PM',
															'23:00:00' => '11.00PM', '23:30:00' => '11.30PM'
														), $operating->close,['class' => 'form-control']) !!}
											</div>
										</div>
									</div>
								</div>
								<?php
							}
							?>							
						</div>
					</div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.restaurant.restaurant.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
                    { key: 'b', route: "<?= route('admin.restaurant.restaurant.index') ?>" }
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
