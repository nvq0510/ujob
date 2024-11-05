{{-- resources/views/components/confirm.blade.php --}}
<!-- Modal Confirm -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">確認</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                本当にこの操作を実行しますか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-primary" id="confirmActionBtn">確認</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        let formToSubmit;

        $('.confirmable-action').on('click', function(e) {
            e.preventDefault();
            formToSubmit = $(this).closest('form');
            $('#confirmModal').modal('show');
        });

        $('#confirmAction').on('click', function() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
    });
</script>
