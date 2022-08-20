@extends('frontend.master')

@section('frontend')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">
        <div class="container">
            <div class="row gy-4 d-flex justify-content-between">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h2 data-aos="fade-up">Shorten, share and track</h2>
                    <p data-aos="fade-up" data-aos-delay="100">
                        Your shortened URLs can be used in publications, documents, advertisements, blogs, forums, instant messages, and other locations. Track statistics for your business and projects by monitoring the number of hits from your URL with the click counter, you do not have to register.
                    </p>

                    <div id="responseMessage" class="row gy-4" data-aos="fade-up" data-aos-delay="400">
                        <small id="errorMsg"></small>
                    </div>


                    <form id="myForm" method="post" class="form-search d-flex align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">
                        @method('POST')
                        @csrf
                        <input type="text" name="user_url" id="user_url" class="form-control" placeholder="Paste Your URL to be shortened">
                        <input type="hidden" id="action" value="">
                        <input type="hidden" id="generated_id" value="">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <div id="urlResult" class=" d-flex align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">

                    </div>

                    <div class="row gy-4" data-aos="fade-up" data-aos-delay="400">
                        <p>Track <a href="#clicks">the total of clicks</a> in real-time from your shortened URL.</p>
                    </div>
                </div>

                <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                    <img src="{{asset('frontend')}}/assets/img/hero-img.svg" class="img-fluid mb-3 mb-lg-0" alt="">
                </div>

            </div>
        </div>
    </section>
    <!-- End Hero Section -->


    <!-- ======= Call To Action Section ======= -->
    <section id="call-to-action" class="call-to-action">
        <div class="container" data-aos="zoom-out">

            <div id="clicks" class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3>Track the total of clicks in real-time</h3>
                    <p> Our tool will count each click as one hit to the long URL, even if there are multiple clicks from the same person or device. </p>

                    <div class="row">
                        <form id="myClickCountForm" method="post" class="form-search d-flex align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">
                            @method('POST')
                            @csrf
                            <input type="text" name="shareUrl" id="shareUrl" class="form-control m-2" placeholder="Share Your Generated URL">
                            <button type="submit" class="btn btn-success m-2 p-3">Check</button>
                        </form>
                    </div>

                    <br>

                    <div id="totalClick">

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Call To Action Section -->
@endsection

@push('extraScript')
    <script>
        $(document).ready(function() {
            submitForm();
            totalClickCount();
        });

        function myFunction() {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

        }

        function canvasFire() {


            var duration = 10 * 500;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                var particleCount = 50 * (timeLeft / duration);
                // since particles fall down, start a bit higher than random
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);



        }

        function myFormReset() {
            $('#myForm')[0].reset();
            $('#action').val('');
            $('#generated_id').val('');
        }

        function validationAndSuccessMsg() {
            $('#errorMsg').html('');
            $('#successMsg').html('');
        }

        function submitForm() {
            $('#myForm').on('submit', function(e) {
                e.preventDefault();

                var url = "{{route('user.url.store')}}";

                if ($('#action').val() === 'edit') {
                    var Id = $('#generated_id').val();
                    url = "{{ route('user.url.update',['id' => '__Id']) }}";
                    url = url.replace("__Id", Id);
                }

                var formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    complete: function(data) {

                       validationAndSuccessMsg();

                        if (data.status === 422) {
                            $.each(data.responseJSON.errors, function(key, value) {
                                console.log(value);
                                //errorMessage(value);
                                $('#errorMsg').html(value);
                                $('#urlResult').html('');
                            });
                            return;
                        }

                        if (data.status >= 400) {
                            //errorMessage(data.responseJSON.message);
                            $('#errorMsg').html(data.responseJSON.message);
                            $('#urlResult').html('');
                            return;
                        }
                        $('#urlResult').html(data.responseText);
                        canvasFire();
                        myFormReset();

                    },
                });

            });

        }

        function customizeFunction(id){
            $('#action').val('edit');
            $('#generated_id').val(id);
            $('#user_url').val($('#myInput').val());
            $('#urlResult').html(' ');
        }

        function totalClickCount() {
            $('#myClickCountForm').on('submit', function(e) {
                e.preventDefault();

                var url = "{{route('user.url.clickCountByLink')}}";

                var formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend:function(){
                        let loading =  ' <img id="loadingImage" src="{{asset('frontend')}}/assets/img/loading2.gif" class="img-fluid" alt="Loading">';
                        $('#totalClick').html(loading);
                    },
                    complete: function(data) {
                        $('#totalClick').html(data.responseText);
                    },
                });

            });
        }

    </script>

    <script>
        <!-- Disable View Source  -->
        document.onkeydown = function(e) {
            if(e.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
            }

            if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
                return false;
            }
        }
    </script>
@endpush
