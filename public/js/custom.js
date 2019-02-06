$("document").ready(function () {
    $('input[type=file]').change(function () {
        $('#document-input-root').append(
            '<input type="file" accept="image/*" name="document[]" id="document" class="form-control-file">'
        );
        redeclare();
    });
    function redeclare() {
        $('input[type=file]').change(function () {
            $('#document-input-root').append(
                '<input type="file" accept="image/*" name="document[]" id="document" class="form-control-file">'
            );
            redeclare();
        });
    }
});
