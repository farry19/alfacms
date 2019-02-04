@include(layouts/header)
<main role="main" class="col-md-9 col-lg-10" style="margin-left: 200px;">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pages</h1>    
  </div>
  <div class="container">
	<table class="table">
		<tr>
			<th>ID</th>
			<th>Page</th>
			<th>Status</th>
		</tr>
		@foreach($pages as $page)
		<tr>
			<td>{{ $page->id }}</td>
			<td>{{ $page->title }}</td>
			<td>{{ $page->status }}</td>
		</tr>
		@endforeach
	</table>
</div>

  <!-- dashboard content here -->

</main>
@include(layouts/footer)