<script>
    $(document).ready(function() {
        var table = document.querySelector('#penduduk-table');
        const documentTitle = '{{ $title }}';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [{
                extend: 'excelHtml5',
                title: documentTitle,
                footer: true
            }]
        }).container().appendTo($('#output_download_penduduk'));

        $('#export-penduduk').on('click', function() {
            $('.dt-buttons .buttons-excel').click();
            return false;
        });
    });
</script>
