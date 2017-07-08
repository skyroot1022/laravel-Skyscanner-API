<!--
    <p class="no-margin">{{ $flight->voteCountNormalized() }}</p>
    <p class="no-margin">{{ $flight->skyScannerUrl() }}</p>
-->
<div class="row result mb15" data-flight="{{ $flight->id }}">
    <div class="col-md-1">
        <?php $btnDisabled = $flight->votes()->where('user_id',  \Cookie::get('uuid'))->count() > 0 ? 'disabled="disabled"' : ''; ?>

            <button type="button"
                id="testBtn"
                {{$btnDisabled}}
                class="btn btn-success btn-block"
                data-upvote="{{ $flight->id }}">
            <i class="fa fa-thumbs-up"></i>
        </button>
        <button type="button" id="testBtnDown" {{$btnDisabled}} class="btn btn-danger btn-block" data-downvote="{{ $flight->id }}">
            <i class="fa fa-thumbs-down"></i>
        </button>
    </div>
    <div class="col-md-3">
        <p class="centered">{{ $flight->to }}
            <br> <span class="smaller">{{ $flight->voteCountNormalized() }} votes</span></p>
    </div>

    <div class="col-md-5">
        <p class="centered">{{ $flight->dateFrom->toFormattedDateString() }} - {{ $flight->dateTo->toFormattedDateString() }}
        <br> <span class="smaller">{{ $flight->dateFrom->diffForHumans() }}</span></p>
    </div>

    <div class="col-md-1">
        <p class="centered">£{{ $flight->price }}</p>
    </div>
    <div class="col-md-2">
        <p class="centered"><a href="{{ $flight->skyScannerUrl() }}" class="btn btn-system btn-block" target="_blank"> Find Similar!</a></p>

    </div>
</div>

<hr>
