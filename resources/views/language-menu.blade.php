<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-language"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">

                @foreach($locale['languages'] as $key => $language)
                    <li><!-- start message -->
                        <a class="language" href="#" data-id="{{$key}}">
                            {{$language}}
                            @if($key == $locale['current'])
                                <i class="fa fa-check pull-right"></i>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</li>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $(".language").click(function () {
        let id = $(this).data('id');
        $.post(`{{$locale['path']}}`,{locale: id,provider:`{{$locale['provider']}}`}, function () {
            location.reload();
        })
    })
</script>
