{{ Html::script('js/jquery-1.9.1.min.js') }}
{{ Html::script('js/bootstrap.min.js') }}
{{ Html::script('js/datepicker/bootstrap-datepicker.js') }}
{{ Html::script('js/datepicker/locales/bootstrap-datepicker.nl.js') }}

<script>
    $(function() {
        $("[type=date]").attr("type", "text").datepicker({
            'language': 'nl',
            'format': 'dd-mm-yyyy'
        });
    });
</script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

@yield('scripts', '')