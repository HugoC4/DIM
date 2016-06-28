@extends("layouts.dashboard")

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">@yield('dataTypes', '') Updaten</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>@yield('dataType', '') ID</th>
                                <th>@yield('dataType', '') Naam</th>
                                @if(isset($hasLimit))
                                    <th>@yield('dataType', '') Limiet</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $kv)
                                <tr>
                                    <td>{{$kv[0] === null ? '[nieuw]' : $kv[0]}}</td>
                                    <td>{{$kv[1]}}</td>
                                    @if(isset($hasLimit))
                                        <td>{{$kv[2]}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="col-md-12 marginTop">
                        @if(isset($reason))
                            <div class="col-sm-12">
                                <i>{{$reason}}</i>
                            </div>
                        @endif
                        <div class="col-sm-4">
                            <button type="button" id="newRow" class="btn btn-primary btn-block btn-flat">Nieuwe @yield('dataType')</button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" id="editRow" class="btn btn-primary btn-block btn-flat" disabled="disabled">@yield('dataType') Aanpassen</button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" id="removeRow" class="btn btn-primary btn-block btn-flat" disabled="disabled">@yield('dataType') Verwijderen</button>
                        </div>
                        <div class="col-sm-12 marginTop">
                            <button type="button" id="saveData" class="btn btn-primary btn-block btn-flat">Opslaan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newRowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nieuwe rij toevoegen</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="control-label">@yield('dataType') naam</label>
                        <div class="col-md-12">
                            <input type="text" id="rowName" class="form-control">
                        </div>
                    </div>
                    @if(isset($hasLimit))
                    <div class="col-md-12">
                        <label class="control-label">@yield('dataType') limiet</label>
                        <div class="col-md-12">
                            <input type="number" id="rowLimit" class="form-control">
                        </div>
                    </div>
                    @endif
                    <div class="clearfix" ></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                    <button type="button" id="newRowAdd" class="btn btn-primary">Toevoegen</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editRowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nieuwe rij toevoegen</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="control-label">@yield('dataType') naam</label>
                        <div class="col-md-12">
                            <input type="text" id="editName" class="form-control">
                        </div>
                    </div>
                        @if(isset($hasLimit))
                        <div class="col-md-12">
                            <label class="control-label">@yield('dataType') limiet</label>
                            <div class="col-md-12">
                                <input type="number" id="editLimit" class="form-control">
                            </div>
                        </div>
                        @endif
                    <div class="clearfix" ></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                    <button type="button" id="editRowEdit" class="btn btn-primary">Aanpassen</button>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden">
        @yield('form', '')
    </div>
@endsection

@section('css')
    {{ Html::style('css/dataTables.bootstrap.css') }}
    {{ Html::style('css/jquery.dataTables.min.css') }}
    {{ Html::style('css/dataTables.responsive.css') }}
    {{ Html::style('https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css') }}
@endsection

@section('scripts')
    {{ Html::script('js/jquery.dataTables.min.js') }}
    {{ Html::script('js/dataTables.bootstrap.min.js') }}
    {{ Html::script('js/dataTables.responsive.min.js') }}
    {{ Html::script('https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js') }}

    <script>
        $(function () {
            window.dataTable = $('#dataTable').DataTable({
                paging: false,
                select: 'single',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Dutch.json"
                }
            });

            $('#dataTable tbody').on('click', 'tr', function () {
                if(!$(this).hasClass("selected"))
                    $('#dataTable tbody tr.selected').removeClass("selected");
                $(this).toggleClass('selected');
                if($(this).hasClass("selected"))
                    $("#editRow, #removeRow").removeAttr("disabled");
                else
                    $("#editRow, #removeRow").attr("disabled", "disabled");
            } );

            $("#newRow").click(function(){
                $("#newRowModal").modal('show');
            });

            $("#editRow").click(function(){
                $("#editName").val(dataTable.row('.selected').data()[1]);
                @if(isset($hasLimit))
                    $("#editLimit").val(dataTable.row('.selected').data()[2]);
                @endif
                $("#editRowModal").modal('show');
            });

            $("#removeRow").click(function(){
                if(!confirm("Weet u zeker dat u deze sector wilt verwijderen?"))
                        return;

                dataTable.row(".selected").remove().draw(false);
                $("#editRow, #removeRow").attr("disabled", "disabled");
            });

            $("#newRowAdd").click(function(){
                if($("#rowName").val().trim() == "")
                    return;
                dataTable.row.add([
                    '[nieuw]',
                    $("#rowName").val()
                        @if(isset($hasLimit))
                            , $("#rowLimit").val()
                        @endif
                ]).draw(false);
                $("#newRowModal").modal('hide');
                $("#rowName").val("")
                $("#rowLimit").val("")
            });

            $("#editRowEdit").click(function(){
                if($("#editName").val().trim() == "")
                    return;
                dataTable.row(".selected").data([
                    dataTable.row(".selected").data()[0],
                    $("#editName").val()
                    @if(isset($hasLimit))
                        , $("#editLimit").val()
                    @endif
                ]);
                $("#editRowModal").modal('hide');
                $("#editName").val("")
            });

            $("#saveData").click(function() {
                var formData = [];
                dataTable.data().each(function(row){
                    formData[formData.length] = [
                        row[0] == "[nieuw]" ? null : row[0],
                        row[1].trim()
                        @if(isset($hasLimit))
                            , row[2]
                        @endif
                    ];
                });
                var input = $("<input name='data' type='hidden'>");
                input.val(JSON.stringify(formData));
                $('form').append(input).submit();
            })
        } );
    </script>
@endsection
