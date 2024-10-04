<script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('backend/js/custom.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
@endif

@if(session()->get('error'))
    <script>
        toastr.error('{{ session()->get('error') }}');
    </script>
@endif

@if(session()->get('success'))
    <script>
        toastr.success('{{ session()->get('success') }}');
    </script>
@endif


<script>
    function change_status(id,model){
        $.ajax({
            type:"get",
            url:"{{url('/admin/change-status/')}}"+"/"+id+"/"+model,
            success:function(response){
               toastr.success(response)
            },
            error:function(err){
                console.log(err);
            }
        })
    }
</script>

{{-- <script>
    var loadFile = function(event) {
      var output = document.getElementById('output');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    };
  </script> --}}


  {{-- <script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        var file = event.target.files[0];
        if (file) {
            var imageUrl = URL.createObjectURL(file);
            output.src = imageUrl;
            document.getElementById('lightboxLink').href = imageUrl; // Update the link for Lightbox
        }
    };
</script> --}}
{{--
<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1000; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.9); /* Black with opacity */
    }

    .modal-content {
        margin-top: 20px !important;
        margin: auto;
        display: block;
        width: 50% !important; /* Width of the modal image */
        max-width: 700px; /* Max width */
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #ffffff !important;
        font-size: 2.5rem !important;
        font-weight: bold;
        cursor: pointer;
    }
</style> --}}

<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        var file = event.target.files[0];
        if (file) {
            var imageUrl = URL.createObjectURL(file);
            output.src = imageUrl;
        }
    };

    function zoomImage(img) {
        console.log(img);
        var modal = document.getElementById("modal");
        var modalImg = document.getElementById("modalImage");
        var captionText = document.getElementById("caption");

        modal.style.display = "block";
        modalImg.src = img.src;
        captionText.innerHTML = img.alt; // If you want to add captions
    }

    function closeModal() {
        var modal = document.getElementById("modal");
        modal.style.display = "none";
    }
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $(".my-select2-class").select2({
            placeholder: "-Please Select-",
            allowClear: true
        });
    });
</script>>
