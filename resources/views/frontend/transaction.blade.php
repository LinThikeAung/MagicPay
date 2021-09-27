@extends('frontend\layouts.app')
@section('title','Transaction')
@section('content')
    <div class="transaction mb-3">
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
                                {{ $transaction->created_at }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        {{ $transactions->links() }}
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
        });
    </script>
@endsection
