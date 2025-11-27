$('#miTabla').DataTable({
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
    initComplete: function () {
        let api = this.api();

        // 1. Obtener el elemento de input de búsqueda global
        const searchInput = $('div.dataTables_filter input');
        
        // 2. Limpiar el filtro que DataTables aplica por defecto a la tabla global
        api.search('').draw(); 

        // 3. Desactivar los eventos originales del input de búsqueda
        searchInput.off('keyup.DT search.DT'); 
        
        // 4. Asignar nuestra función personalizada
        searchInput.on('keyup.custom search.custom', function () {
            
            // Término escrito por el usuario
            const termino = this.value; 
            
            // ----------------------------------------------------
            // 5. Aplicar el término SÓLO a la Columna 1 (Índice 0)
            // ----------------------------------------------------
            
            // Aplicar el nuevo término a la Columna 1 (Índice 0)
            api.column(0).search(termino, true, false).draw();
            
            // Opcional: Limpiar el filtro global de la API (para que DataTables no lo intente aplicar más tarde)
            api.search(termino).draw(); // Esto es solo para que la API mantenga el valor
        });
    }
});