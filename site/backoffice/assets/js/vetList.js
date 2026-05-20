let table= new DataTable('#vetsTable', {
    "language": {
        "url": "assets/js/pt_PT.json"
    },
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    columns: [null, null, { orderable: false }, null, null, { orderable: false }]
});