<div class="grid-stack-item">
	<div class="grid-stack-item-content">
		<!-- small box -->
		<div class="small-box bg-blue">
			<div class="inner">
				<h3>{!! $feedbackCount !!}</h3>

				<p>Feedbacks</p>
			</div>
			<div class="icon">
				<i class="fa fa-envelope-o"></i>
			</div>
			<a href="{{ route('admin.feedback.feedback.index')  }}" class="small-box-footer">
			  More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
</div>
