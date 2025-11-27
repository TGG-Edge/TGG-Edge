@extends('tgg-fct.layouts.app')

@section('title', 'Knowledge and Research | Tgg Edge | Tgg Fct')

@section('content')
<div class="container">
    <h3 class="mb-3 knowledge">📖 KNOWLEDGE & RESEARCH</h3>

    <div class="row mb-3">
        <div class="col-12 col-md-10">
            <form id="search_form" method="POST" class="d-flex">
                @csrf
                <input type="text" id="searchData" class="form-control me-2" style="font-size: 13px;" placeholder="Example: Rural Development and Sustainable Living..." name="searchData">
                <button type="submit" class="btn btn-outline-secondary" id="searchAI"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <button class="btn btn-primary mb-3" type="button" id="loaderIcon" style="display:none" disabled>
        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
        Please wait, Loading...
    </button>

    <div class="row">
        <div class="col-12 message api-msg"></div>
        <div class="col-12 error text-danger"></div>
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
            $('.message').empty().hide();
            $('.error').empty();
            e.preventDefault();
            let form = $('#search_form')[0];
            let data = new FormData(form);
            $('#loaderIcon').show();
            $.ajax({   
                url: "{{ route('tgg-fct.knowledge-research.search-knowledge') }}",
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
