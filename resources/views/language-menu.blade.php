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
                        <a class="language" href="#" data-id="{{$key}}" data-label="{{$language}}">
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
        $.admin.toastr.success(`{{__('messages.switch_language_to')}}`+$(this).data('label'), '', {positionClass:"toast-top-center"});
        let id = $(this).data('id');
        $.post(`{{$locale['path']}}`,{locale: id,provider:`{{$locale['provider']}}`}, function () {
            location.reload();
        })
    })
</script>
