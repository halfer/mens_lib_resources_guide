
<?php
	$tags = \App\Tag::orderBy('name')->get();
?>

@extends('layouts.app')

@section('title')
	| Resources
@endsection

@section('content')

<div class="row">
	<div class="col-xs-12 col-md-10 col-md-offset-1">
		<h1>Welcome to the Men's Lib resources guide!</h1>
		Here you'll find a collectiong of resources geared towards men in a variety of situatoins and with a variate of backgrounds.
		<br/><br/>
		<a href="/resources/about">Click here</a> to find out how the search form works.
		<br/><br/>
		{!! link_to_action('ResourceController@create', 'Click here') !!} to add resources to the database.
	</div>
	<div class="col-xs-12">&nbsp;</div>
	<div class="col-xs-12">&nbsp;</div>
	<div class="col-xs-12 col-md-10 col-md-offset-1 panel">
		<button type="button" class="btn btn-info btn-lg collapse-btn" data-toggle='collapse' data-target='#search-form'>
			<span class="text">
				Search for Resources&nbsp;&nbsp;@include('templates.glyphicon', ['type' => 'chevron-right'])
			</span> 
			<span class="text" style="display:none;">
				Hide Search Form&nbsp;&nbsp;@include('templates.glyphicon', ['type' => 'chevron-down'])
			</span> 
		</button>
		<script>
			$(".collapse-btn").click(function(){
				$(this).find('.text').toggle();
			});
		</script>
		<div id='search-form' class='collapse'>
			<div class="col-xs-12">&nbsp;</div>
			<!-- Hidden checkbox field for tags -->
			@include('templates.tag_selector', ['selected_tags' => isset($selected_tags) ? $selected_tags : null])
			<div>&nbsp;</div>
			<div>&nbsp;</div>
			<?php $glyphicon = view('templates.glyphicon', ['type' => 'search'])->render() . '&nbsp;'; ?>
			@include('templates.buttons.search', 
				['text' => 'Get Resources With Any Of These Tags', 'class' => 'search-any'])
			&nbsp;
			@include('templates.buttons.search', 
				['text' => 'Get Resources With All Of These Tags', 'class' => 'search-all'])
			<div>&nbsp;</div>
			<hr/>
			<div id='search-text-container' class="form">
					{!! Form::label('search-text', 'Text-based search') !!}
					{!! Form::text('search-text', null, ['class' => 'form-control', 'id' => 'text-search-input']) !!}
					<br/>
					@include('templates.buttons.search', 
						['text' => 'Search', 'class' => 'search-text'])
			</div>
		</div>
	</div>
		<script>
			$(".search-any, .search-all").click(function(e){
				e.preventDefault();
				var tagsSelected = [];
				$('.hidden-tag-fields input:checked').each(function(i, e){
					//Get tag name by finding the tag this checkbox references (the checkbox value is the tag id)
					tagsSelected.push(
						$('.tag-cloud').find('.tag[data-id=' + $(e).val() + ']').data('name')
					);
				});
				var queryString = tagsSelected.join('+');
				var redirectUrl = '/resources/';
				redirectUrl += $(this).hasClass('search-any') ? 'has-any/' : 'has-all/';
				redirectUrl += queryString;
				window.location.href = redirectUrl; 
			});
			$('.search-text').click(function(){
				var queryString = $('#text-search-input').val().split(' ').join('+').toLowerCase();
				var redirectUrl = '/resources/search/' + queryString;
				console.log(redirectUrl);
				window.location.href = redirectUrl; 
			});
		</script>
</div>

@if ($resources->count() > 0)
	@foreach ($resources as $resource)
		@include('templates.resource', ['resource' => $resource])
	@endforeach
@else
	<div class="row">
		<h4 class="col-xs-10 col-xs-offset-1">Sorry, we couldn't find any resources matching your search criteria.</h4>
	</div>
@endif

@endsection





