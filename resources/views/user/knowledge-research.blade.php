@extends('user.layouts.app')

@section('title', 'Knowledge and Research')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">📖 Knowledge & Research</h3>
    <!-- <p>This section will host blog posts, insights, field research data, and articles from the TGG team and global collaborators.</p>
    <ul>
        <li><strong>Blog:</strong> Rethinking Rural Sustainability in India</li>
        <li><strong>Insight:</strong> Digital Tools for Grassroots Empowerment</li>
        <li><strong>Report:</strong> AI-Powered Solutions in Agriculture</li>
    </ul> -->
    <div class="input-group search-container">
        <form id="search_form" method="POST" class="col-md-10">
            @csrf
            <input type="text" class="col-md-11" style="padding: 1%;margin-top: 8px;font-size: 17px;" placeholder="Example: Rural Development and Sustainable Living..." name="searchData">
			<button type="submit" style="font-size: larger;padding: 1%;" id="searchAI" type="button"><i class="fa fa-search"></i></button>
        </form>
    </div>
	<button class="btn btn-primary" type="button" id="loaderIcon" style="display:none" disabled>
		<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
		Please wait, Loading...
	</button>
	<div class="message"></div>
	<div class="error"></div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#searchAI").click(function(e){
			$('.message').empty();
			$('.error').empty();
            e.preventDefault();
            //serializing form data       
            let form = $('#search_form')[0];
            let data = new FormData(form);
			//Loader show
			$('#loaderIcon').show();
            $.ajax({   
                url: "{{ route('user.knowledge-research.search-knowledge') }}",
                type: "POST",
                data : data,
                dataType:"JSON",
                processData : false,
                contentType:false,  
                success : function(data) {
					$('#loaderIcon').hide();
                    $(".message").html(data.success);  
                }, 
                error : function(data) {
					$('#loaderIcon').hide();
					$(".error").html(data.error);
                } 
            });
        });
    });
</script>