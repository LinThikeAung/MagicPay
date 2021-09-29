@extends('frontend\layouts.app')
@section('title','Transaction')
@section('content')
    <div class="transaction mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-left text-muted mb-3">Filter</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <label class="input-group-text p-1">Date</label>
                            <input type="text" class="form-control date" value="{{ request()->date ?? date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <label class="input-group-text p-1">Transaction Type</label>
                            </div>
                            <select class="custom-select type">
                            <option value="">All</option>
                            <option value="1" @if(request()->type == 1) selected @endif >Income</option>
                            <option value="2" @if(request()->type == 2) selected @endif>Expense</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="infinite-scroll">
            @foreach ($transactions as $transaction )
                <div class="card mycard">
                    <a href="{{ url('transaction/detail',$transaction->trx_id) }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3>{{ $transaction->trx_id }}</h3>
                                <p class="mb-1 @if($transaction->type == 1 ) text-success @elseif($transaction->type == 2) text-danger @endif">
                                    @if($transaction->type == 1)
                                        +{{ $transaction->amount }} MMK
                                    @elseif($transaction->type == 2)
                                        -{{ $transaction->amount }} MMK
                                    @endif
                                </p>
                            </div>
                            <p class="mb-2 text-muted">
                                @if($transaction->type == 1)
                                    From
                                @elseif($transaction->type == 2)
                                    To =>
                                @endif
                                {{-- source joined with eloquent --}}
                                {{ $transaction->source ? $transaction->source->name : '' }}
                            </p>
                            <p class="text-muted">
                                {{ $transaction->created_at->format('Y-m-d') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        {{-- {{ $transactions->links() }} normal --}}
        {{ $transactions->appends(['type' => request()->type,'created_at'=>request()->type ])->links() }}
        {{-- pagination ko get->request nae pyan filter dr

            $transactions->where('type',request()->type)
            query dway write loz lal ya dl
            view mar where function nae filter lote tha lo bl
        --}}
        </div>
    </div>
@endsection
@section('scripts')
<script>
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="text-center"><img src="/images/loading.gif" alt="Loading..." /></div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });

            $('.date').daterangepicker({
                "singleDatePicker": true,
                "autoApply" : true,
                "locale": {
                    "format" : "YYYY-MM-DD"
                },
            });
            $('.date').on('apply.daterangepicker', function(ev, picker) {
                var date = $('.date').val();
                var type = $('.type').val();
                history.pushState(null,'',`?date=${date}&type=${type}`);
                window.location.reload();
            });


            $('.type').change(function(){
                var type = $('.type').val();
                var date = $('.date').val();
                //normal url ka 127.0.0.1:8000/transaction
                // d lo url link ko lyan push lite dot 127.0.0.1:8000/transaction?type=1or2
                //history.pushState(null,'','?type='+type); normal js
                //ES6 ``<- features
                history.pushState(null,'',`?date=${date}&type=${type}`);
                window.location.reload();
             })
        });
    </script>
@endsection
