<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalHeader">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="deleteModalText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button" data-dismiss="modal">No, close</button>
                <form method="POST" action="{{ $route }}">
                    @csrf
                    <input name="deleteIds" type="hidden" id="deleteModalIds">
                    <input name="list" type="hidden" value="{{ $list }}">
                    <button id="deleteModalBtn" type="submit" class="button button--danger">Yes, delete</button>
                </form>
            </div>
        </div>
    </div>
</div>