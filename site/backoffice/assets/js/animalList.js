let table = new DataTable('#animalTable', {
    language: {
        url: 'assets/js/pt_PT.json',
    },
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],   
    columns: [null,{ orderable: false,width: '100px' }, null, null, null, null,{ width: '600px' }, null, {orderable: false}] 
});