<footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
    @php
        $Office = Storage::disk('local')->get('office');
        $OfficE = json_decode($Office);
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-center text-md-left text-primary">
                <p class="mb-2 mb-md-0">
                    @if($OfficE && $OfficE->footer)
                        {{$OfficE->footer}}
                    @else
                        European IT &copy; 2019-2020
                    @endif
                </p>
            </div>
            <div class="col-md-6 text-center text-md-right text-gray-400">
                <p class="mb-0">Developed by <a href="https://euitsols.com/" target="_blank"
                                             class="external text-gray-400">European IT</a></p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<!-- JavaScript files-->
<script src="{{asset('bubbly/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('bubbly/vendor/popper.js/umd/popper.min.js')}}"></script>
<script src="{{asset('bubbly/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('bubbly/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
{{--<script src="{{asset('bubbly/vendor/chart.js/Chart.min.js')}}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
{{--<script src="{{asset('bubbly/js/charts-home.js')}}"></script>--}}
<script src="{{asset('bubbly/js/front.js')}}"></script>

<script>
    $(function () {
        $('#sidebar li a').filter(function () {
            return this.href === location.href;
        }).addClass('active').closest("div").addClass('show');
    });
</script>


