<form method="POST" action="{{ route('leases.comment.add') }}" id="commentForm" enctype="multipart/form-data">
    @csrf
    <div class="row mg-b-30">

        <div class="col-sm-12">
            <div class="form-group m-0">
                <label for="" class="mb-1 tx-medium">Comment</label>
                <input type="hidden" name="id" value="{{ $data->id }}">
                <textarea id="comment" name="comment" class="form-control" cols="30" rows="3" required
                          placeholder="Comment">{{ $data->comment }}</textarea>
            </div>
        </div>
    </div>
    <div class="btn_loader_wrap add position-relative d-flex align-items-center justify-content-end ml-auto submitBtn mt-3">
        <div class="btn_loader">
            <div class="loader"></div>
        </div>
        <button class="btn btn-primary download-btn" type="submit">Submit</button>
    </div>
    {{--<div class="text-right submitBtn">
        <button class="btn btn-primary download-btn" type="submit">Submit</button>
    </div>--}}

</form>
