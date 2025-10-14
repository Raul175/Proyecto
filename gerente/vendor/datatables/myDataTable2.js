$('#miTabla2').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    responsive: true,
    pageLength: 5,
    lengthMenu: [5, 10, 20, 50],
    language: {
    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
    },
});