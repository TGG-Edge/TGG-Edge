@extends('user.layouts.app')

@section('title', 'Knowledge and Research - TGG Edge')

@section('content')
<div class="container">
    <h3 class="mb-3 knowledge">📖 KNOWLEDGE & RESEARCH</h3>
    <!-- <p>This section will host blog posts, insights, field research data, and articles from the TGG team and global collaborators.</p>
    <ul>
        <li><strong>Blog:</strong> Rethinking Rural Sustainability in India</li>
        <li><strong>Insight:</strong> Digital Tools for Grassroots Empowerment</li>
        <li><strong>Report:</strong> AI-Powered Solutions in Agriculture</li>
    </ul> -->
    <div class="input-group search-container">
        <form id="search_form" method="POST" class="col-md-10">
            @csrf
            <input type="text" id="searchData" class="col-md-11 knowledge-innertext" style="padding: 1%;font-size: 13px;" placeholder="Example: Rural Development and Sustainable Living..." name="searchData">
			<button type="submit" class="btn btn-outline-secondary knowledge-search" style="margin-bottom: 11px;" id="searchAI" type="button"><i class="fa fa-search"></i></button>
        </form>
    </div>
	<button class="btn btn-primary" type="button" id="loaderIcon" style="display:none" disabled>
		<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
		Please wait, Loading...
	</button>
<div class="row">
    <div class="message api-msg"></div>
	<div class="error"></div>
</div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#searchAI").on('click', function(e){
            if($('#searchData').val() == ''){
                $('.error').html('Please provide input value');
                return false;
            }
			$('.message').empty();
            $('.message').hide();
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
                    $('.message').show();
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