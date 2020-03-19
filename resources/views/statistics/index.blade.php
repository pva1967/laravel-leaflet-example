@extends('layouts.app')

@section('title', __('outlet.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @if (Request::is('admin/*'))
        <a href="{{ route('admin.outlets.create') }}" class="btn btn-success">{{ __('outlet.create') }}</a>
        @else
            <a href="{{ route('outlets.create') }}" class="btn btn-success">{{ __('outlet.create') }}</a>
        @endif
    </div>
    <h1 class="page-title">{{ __('outlet.list') }}</h1>
</div>
<form method="GET" action="" accept-charset="UTF-8" class="form-inline">
    <div class="form-group">
        <label for="q" class="control-label">Период:</label>
        <input placeholder="От" name="from" type="text" id="datepicker_from" class="form-control mx-sm-2" value="{{ request('from') }}">
        <input placeholder="До" name="to" type="text" id="datepicker_to" class="form-control mx-sm-2" value="{{ request('to') }}">
    </div>
    <input type="submit" value="Получить статистику" class="btn btn-secondary">
</form>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div>{{$from}}</div><div>{{$to}}</div>
            <table class="table table-sm table-responsive-sm">
                <thead>
                <tr>
                    <th class="text-center">Прокси</th>
                    <th>РЕалм</th>
                    <th>Уник</th>
                    <th>time_stamp</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $stats as $key => $stat)
                <tr>

                    <td>{{ $stat->proxy }}</td>
                    <td>{{  $stat->realm}}</td>
                    <td>{{  $stat->unique }}</td>
                    <td>{{  $stat->time_conn }}</td>
                </tr>
                @endforeach
                </tbody>


            </table>
            <div class="card-body">{{ $stats->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script>
            $(function() {
                let d = new Date(Date.now());
               let nowDate = conDate(d) ;
               d = '01/03/2020';
               let startDate = '01/03/2020';
               let maxDate = nowDate;
               let minDate = startDate;
               let tempMinDate = $( "#datepicker_from" ).val();
               let tempMaxDate = $( "#datepicker_to" ).val();

               minDate = (tempMinDate > minDate) ?  tempMinDate : minDate;
               console.log(new Date(tempMinDate), new Date(minDate));
                $("#datepicker_to").datepicker("option", { minDate: minDate });
               maxDate = (tempMaxDate < maxDate) ?  tempMaxDate : maxDate;
                $("#datepicker_from").datepicker("option", { maxDate: maxDate });
                $( "#datepicker_from" ).datepicker(
                    {
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        showAnim: "clip",
                        dateFormat: "dd/mm/yy",
                        minDate: startDate,
                        maxDate: maxDate,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1925:2050",
                        regional: "ru"
                    }).on('change', function (){
                     $("#datepicker_to").datepicker("option", { minDate: this.value });
                    minDate = this.value;
                            });
                $( "#datepicker_to" ).datepicker(
                    {
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        showAnim: "clip",
                        dateFormat: "dd/mm/yy",
                        minDate: minDate,
                        maxDate: nowDate,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1925:2050",
                        regional: "ru"
                    }).on('change', function (){
                    $("#datepicker_from").datepicker("option", { maxDate: this.value });
                        maxDate = this.value;

                });

            });

            function conDate (a) {
                let mm = a.getMonth() + 1;
                let dd = a.getDate();
                let yy = a.getFullYear();
                return (dd + '/' + mm + '/' + yy);
            }


        </script>
@endpush
